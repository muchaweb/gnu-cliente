(function(){
  var form = $('#new-bill #inputs'),
    index  = 0,
    min    = 0,
    max    = 5;

  $('#btn-remove').on('click', function(e){
    index -= 1;
    index = clamp(index, min, max);  
    
    // only remove if index is in range 
    if(index >= min  && index <= max){
      // remove input
      form.find('input#operacion'+index).remove();
    }
  });
  
  $('#btn-add').on('click', function(e){
    index += 1;
    index = clamp(index, min, max);  
    
    var input = $('<input/>',{
      'id' : 'operacion' + index,
      'name' : 'operacion[]',
      'class': 'form-control',
      'placeholder' : 'Número de operación'
    });

    if(index !== max) {
      // add new input
      form.append(input);
    }
  });

  // clamping
  var clamp = function (value, min , max) {
    return Math.min(Math.max(value, min), max);
  };

})();
