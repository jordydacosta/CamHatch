// this will send the headers on every ajax request you make via jquery...
$(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-Token': parent.$('meta[name="csrf-token"]').attr('content')
    }
  });
});

function handleAjaxRequests(route, data, type) {
  return $.ajax({
    url: route,
    data: data,
    dataType: 'json',
    type: type,
    cache: false,
    statusCode: {
      404: handler404,
      500: handler500
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(JSON.stringify(jqXHR) + ' ' + textStatus + ' ' + errorThrown);
    }
  });
}

function handler404() {
  $('#myModal').modal('show');
  $('#modalresponse')
      .html(
          '<div class="alert alert-danger alert-block"><p>The resource could not be found.</p></div>');
}

function handler500() {
  $('#myModal').modal('show');
  $('#modalresponse')
      .html(
          '<div class="alert alert-danger alert-block"><p>A problem occured. The action was not completed.<br/></p></div>');
}
F
function deleteResource(route, data, table, doneFunction) {
  handleAjaxRequests(route, data, 'DELETE').done(function(data) {
    if (data.deleted == 1) {
      $(".modal").modal('hide');
      table.ajax.reload(null, false);

      console.log(typeof doneFunction);
      if (typeof doneFunction == 'function') {
        doneFunction();
      }
    }
  });
}