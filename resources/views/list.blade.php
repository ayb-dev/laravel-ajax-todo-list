<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>List Ajax</title>
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-lg-offset-3 col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Ajax ToDo List <a href="#"  id="addNew" class="pull-right" data-target="#myModal" data-toggle="modal"><i class="fa fa-plus" aria-hidden="true"></i></a></h3>
                        </div>
                         <div class="panel-body">
                            <ul class="list-group" id="items">
                                @foreach($items as $item)
                                <li class="list-group-item ourItem" data-target="#myModal" data-toggle="modal">{{ $item->item }}
                                <input type="hidden" id="itemId" value="{{ $item->id }}">
                                </li>                                
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2">
                    <input type="text" class="form-control" name="item" id="searchItem" placeholder="Search">
                </div>

                <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="title"></h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="close">
                                    <span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="id">
                                <p><input type="text" placeholder="Write Item Here" id="addItem" class="form-control"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning" data-dismiss="modal" id="delete" style="display: none">Delete</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal" id="saveChanges" style="display: none">Save changes</button> 
                                <button type="button" class="btn btn-primary" data-dismiss="modal" id="AddButton">Add Item</button> 

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{ csrf_field() }}

    </body>

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(document).on('click', '.ourItem', function(event){
                var text = $(this).text();
                var text = $.trim(text);
                var id = $(this).find('#itemId').val();
                $('#title').text('Edit Item');
                $('#addItem').val(text);
                $('#delete').show('400');
                $('#saveChanges').show('400');
                $('#AddButton').hide('400');
                $('#id').val(id);
            });

            $(document).on('click', '#addNew', function(event){
                $('#title').text('Add New Item');
                $('#addItem').val('');
                $('#delete').hide('400');
                $('#saveChanges').hide('400');
                $('#AddButton').show('400');           
            });

            $('#AddButton').click(function(event){                    
                var text = $('#addItem').val();
                if(text == ""){
                    alert('Please type eanything for item')
                }else{
                    $.post('list', {'text': text, '_token': $('input[name=_token]').val()}, function(data){
                        console.log(data);
                        $('#items').load(location.href + ' #items');
                    });
                }
                
            });

            $('#delete').click(function(event) {
                var id = $('#id').val();
                $.post('delete', {'id': id, '_token': $('input[name=_token]').val()}, function(data){
                    $('#items').load(location.href + ' #items');
                    console.log(data);
                });
            }); 

            $('#saveChanges').click(function(event) {
                console.log('saveChanges');
                var id = $('#id').val();
                var value = $('#addItem').val();
                $.post('update', {'id': id, 'value': value, '_token': $('input[name=_token]').val()}, function(data){
                    $('#items').load(location.href + ' #items');
                    console.log(data);
                });
            });

        });
    </script>

</html>
