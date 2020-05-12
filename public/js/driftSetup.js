var driftTriggers = document.querySelectorAll('.drift-trigger');

for (var i = 0, len = driftTriggers.length; i < len; i++) {
  var driftTrigger = driftTriggers[i];
  
  new Drift(driftTrigger, {
    containInline: false,
    inlinePane: true,
    inlineOffsetY: -90,
    zoomFactor: 3,
  });
}
