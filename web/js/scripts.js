$(document).on('click', '.new-task', function(e) {
  e.preventDefault();

  $('.new-task-form input[name=id]').val('');

  $('.new-task-form').fadeIn();
});

$(document).on('click', '.cancel-task', function(e) {
  e.preventDefault();

  $('.new-task-form').fadeOut();
});

$(document).on('submit', '.new-task-form', function(e) {
  e.preventDefault();

  $('.new-task-form input[type=submit]').attr('disabled', 'disabled');
  
  $.ajax({
    url: $(this).attr('action'),
    type: 'POST',
    data: $(this).serialize(),
    success: function( resp ) {
      $('#content').load('./index/index/ajax/1', function() {
        $('.new-task-form input[type=submit]').removeAttr('disabled');
        $('.new-task-form').fadeOut();
      });
    },
    error: function() {
      alert('Произошла ошибка, попробуйте еще раз.')
    }
  });
});

$(document).on('click', '.task-end', function(e) {
  e.preventDefault();

  if ( confirm('Удалить задачу?') ) {
    $.ajax({
      url: './task/remove',
      type: 'POST',
      data: {id: $(this).data('id')},
      success: function( resp ) {
        $('#content').load('./index/index/ajax/1');
      },
      error: function() {
        alert('Произошла ошибка, попробуйте еще раз.')
      }
    });

    return true;
  }
});

$(document).on('click', '.task-edit', function(e) {
  e.preventDefault();
  $('.new-task-form').fadeIn();

  var task = $(this).parents('.task');
  var taskb = task.find('.task-bottom');

  $('.new-task-form input[name=id]').val($(this).data('id'));

  $('.new-task-form input[name=title]').val(task.find('h2').html());
  $('.new-task-form textarea[name=desc]').val(task.find('.task-desc').html().replace(/<br>/g, ""));

  $('.new-task-form input[name=h]').val(taskb.data('h'));
  $('.new-task-form input[name=i]').val(taskb.data('i'));
  $('.new-task-form select[name=d]').val(taskb.data('d'));
  $('.new-task-form select[name=m]').val(taskb.data('m'));
  $('.new-task-form select[name=y]').val(taskb.data('y'));
});