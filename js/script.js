(function(){
  var form = $('#new-bill #inputs'),
    index  = 1,
    min    = 1;

  $('#btn-remove').on('click', function(e){

    if(index <= min){
      index = min;
    } else {
      index -= 1;
      form.children().last().remove()
    };

  });
  
  $('#btn-add').on('click', function(e){

    var input = $('<input/>',{
      'id' : 'operacion' + index,
      'name' : 'operacion[]',
      'class': 'form-control',
      'placeholder' : 'Número de operación',
      'autocomplete' : 'off',
      'onpaste' : 'return false'
    });

    form.append(input);
    index += 1;
  });

})();
