"use strict";

var xlsxToArray = (function () {
  function cellRefToIndices(cellRef) {
    var colLetter = cellRef[0];
    var rowIndex = parseInt(cellRef.slice(1), 10);
    var colIndex = colLetter.charCodeAt(0) - 64;

    return { row: rowIndex, col: colIndex };
  }

  function cellIndicesToRef(indices) {
    return String.fromCharCode(indices.col + 64) + indices.row.toString();
  }

  function lastCellIndices(map) {
    var maxRow = 0;
    var maxCol = 0;
    
    for (var cellRef in map) {
      if (map.hasOwnProperty(cellRef)) {
        var cellIndices = cellRefToIndices(cellRef);
        var currentRow = cellIndices.row;
        var currentCol = cellIndices.col;
        
        if (currentRow > maxRow) {
          maxRow = currentRow;
        }
        if (currentCol > maxCol) {
          maxCol = currentCol;
        }
      }
    }

    return { row: maxRow, col: maxCol };
  }

  function fixdata(data) {
    // https://developpaper.com/how-to-parse-excel-files-into-json-format/
    var o = "", l = 0, w = 10240;
    for(; l<data.byteLength/w; ++l) o+=String.fromCharCode.apply(null,new Uint8Array(data.slice(l*w,l*w+w)));
    o+=String.fromCharCode.apply(null, new Uint8Array(data.slice(l*w)));
    return o;
  }

  function fmtThousands(num) {
    // https://stackoverflow.com/questions/2901102/how-to-print-a-number-with-commas-as-thousands-separators-in-javascript
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.")
  }
  
  function parseCells(e, tabelaRows, isFirst) {
    var arr = fixdata(e.target.result);
    var wb = XLSX.read(btoa(arr), { type: "base64" });
    var worksheet = wb.Sheets[wb.SheetNames[0]];

    var map = {};

    for (var z in worksheet) {
      if (z[0] === "!") {
        continue;
      }
      map[z] = worksheet[z].v;
    }

    var lastCell = lastCellIndices(map);
    
    for (var r = 1, lastRow = lastCell.row; r <= lastRow; r++) {
      var row = {};
      var cod = map[cellIndicesToRef({ row: r, col: 1})];
      if (/\d{6}\w{0,2}/.test(cod)) {
        if (cod == "140975") {
          cod = "140975E";
          document.getElementById("errors").innerText += "140975 alterado para 140975E.\n";
        }
        if (cod in tabelaRows) {
          if (map[cellIndicesToRef({ row: r, col: 9 })] > tabelaRows[cod].cv) {
            tabelaRows[cod].cv = map[cellIndicesToRef({ row: r, col: 9 })];
          }
          tabelaRows[cod].disp += Math.max(0, parseInt(map[cellIndicesToRef({ row: r, col: 10})], 10));
          tabelaRows[cod].resv += Math.max(0, parseInt(map[cellIndicesToRef({ row: r, col: 11})], 10));
          if (isFirst) {
            tabelaRows[cod]['disp_ptl'] = Math.max(0, parseInt(map[cellIndicesToRef({ row: r, col: 10})], 10));
            tabelaRows[cod]['resv_ptl'] = Math.max(0, parseInt(map[cellIndicesToRef({ row: r, col: 11})], 10));
          } else {
            tabelaRows[cod]['disp_uni'] = Math.max(0, parseInt(map[cellIndicesToRef({ row: r, col: 10})], 10));
            tabelaRows[cod]['resv_uni'] = Math.max(0, parseInt(map[cellIndicesToRef({ row: r, col: 11})], 10));
          }
        } else {
          var cv = map[cellIndicesToRef({ row: r, col: 9 })];
          if (/\d+\s\/\s\d+/.test(cv)) {
            if (isFirst) {
              tabelaRows[cod] = {nome: map[cellIndicesToRef({ row: r, col: 3})],
                                 cv: cv,
                                 disp: Math.max(0, parseInt(map[cellIndicesToRef({ row: r, col: 10})], 10)),
                                 resv: Math.max(0, parseInt(map[cellIndicesToRef({ row: r, col: 11})], 10)),
                                 disp_ptl: Math.max(0, parseInt(map[cellIndicesToRef({ row: r, col: 10})], 10)),
                                 resv_ptl: Math.max(0, parseInt(map[cellIndicesToRef({ row: r, col: 11})], 10)),
                                 disp_uni: 0,
                                 resv_uni: 0
                                }
            } else {
              tabelaRows[cod] = {nome: map[cellIndicesToRef({ row: r, col: 3})],
                                 cv: cv,
                                 disp: Math.max(0, parseInt(map[cellIndicesToRef({ row: r, col: 10})], 10)),
                                 resv: Math.max(0, parseInt(map[cellIndicesToRef({ row: r, col: 11})], 10)),
                                 disp_ptl: 0,
                                 resv_ptl: 0,
                                 disp_uni: Math.max(0, parseInt(map[cellIndicesToRef({ row: r, col: 10})], 10)),
                                 resv_uni: Math.max(0, parseInt(map[cellIndicesToRef({ row: r, col: 11})], 10))
                                }
            }
          } else {
            document.getElementById("errors").innerText += "CV para " + cod + " invalido.\n";
          }
        }
                           
      }
    }

    return tabelaRows;
  }

  return {
    parse: function(e, callback) {
      var file1 = document.getElementById("fileInput1").files[0];
      var reader = new FileReader();

      var file2 = document.getElementById("fileInput2").files[0];
      var reader2 = new FileReader();

      var tabelaRows = {};

      reader.onload = function(e) {
        tabelaRows = parseCells(e, tabelaRows, true);
        reader2.readAsArrayBuffer(file2);
      }

      reader2.onload = function(e) {
        tabelaRows = parseCells(e, tabelaRows, false);
        // filter rows that have fewer than 10 disp + resv
        var filtered = {};
        for (let k of Object.keys(tabelaRows)) {
          if (tabelaRows[k].disp + tabelaRows[k].resv > 9 && tabelaRows[k].nome.length > 3) {
            filtered[k] = tabelaRows[k];
            filtered[k].disp = fmtThousands(filtered[k].disp);
            filtered[k].resv = fmtThousands(filtered[k].resv);
          }
        }
        callback(filtered);
      }
      
      reader.readAsArrayBuffer(file1);
    }
  }
})();


// process data
document.getElementById("continue").addEventListener("click", function(e) {
  // this.disabled = true;
  document.getElementById("out").innerHTML = "Aguarde...<br><br><br> Se a mensagem ''Gravado o Arquivo HTML estoque_xxxxx''. não aparecer em 5 segundos,<br>recarregue a página clicando no link acima ''Tabela (Upload)'' e <br>tente novamente.";
  xlsxToArray.parse(e, processData);
});

function processData(tabelaRows) {
  var phpTgt = document.getElementById("phpTarget").value;

  $.ajaxSetup({
    timeout: 30000,
    error: function(xhr) {
      $("#errors").html("Erro: " + xhr.status + " " + xhr.statusText);
    }
  });
  
  $.post(phpTgt, JSON.stringify(tabelaRows), function(data) {
    document.getElementById("out").innerHTML = data;

    window.setTimeout(function() {
      document.getElementById("continue").disabled = false;
    }, 500);
  });
}
