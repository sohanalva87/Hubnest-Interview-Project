<!DOCTYPE html>
<html>
    <head>
        <title>Hubnest Contact Page</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <link rel="stylesheet" type="text/css" href="style/node_modules/normalize.css/normalize.css">
        <link rel="stylesheet" type="text/css" href="style/style.css">
    </head>
    <body>
        <div class="container form">
            <div class="row header">

            </div>
            <!-- Show Records -->
            <form>
              <div id="records">

              </div>
            </form>
            <!-- Add New Contact Name -->
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <form>
                        <div class="form-group row">
                            <div class="col-xs-10">
                                <input type="text" class="form-control input-field" id="add-name" placeholder="Enter the name">
                            </div>
                            <div class="col-xs-2">
                                <button class="btn btn-primary add-btn" id="add-name-btn" type="submit">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-2"></div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                  <button id="logout">Logout</button>
              </div>
            </div>
        </div>
    </body>
    <script type="text/javascript">
      "use strict";
        function showDATA(){
            $.ajax({
               type:"post",
               url:"src/postData.php",
               data:{action: "showdata"},
               dataType:"html",
                   success:function(data){
                    $("#records").html(data);
                }
                 });
        }


        function splitString(data) {
            var str = data;
            var res = data.split("-");
            return res;
        }
        function setPlaceholder(id, message,background,color) {
          document.getElementById(id).setAttribute("placeholder", message);
          document.getElementById(id).value = "";
          document.getElementById(id).style.background=background;
          document.getElementById(id).style.color=color;
        }

        showDATA();

        $(document.body).on('click', '.add-btn-2', function(e){
            // do something here
                e.preventDefault();
                var arr = splitString(e.target.id);
                    var phoneType = $("#a-t-".concat(arr[2])).val();
                    var phoneNum = $("#a-p-".concat(arr[2])).val();
                    $.ajax({
                        type: "post",
                        url: "src/postData.php",
                        data: {id: arr[2], type: phoneType, num: phoneNum, action: "addnumber"},
                        dataType: "text",
                       success: function( data ) {
                            if(data == "error : not valid")
                            {
                               setPlaceholder("a-p-".concat(arr[2]),"Invalid Entry!","#ffb2b2","white");
                            }
                            else
                            {
                              setPlaceholder("a-p-".concat(arr[2]),"","white","#999999");
                              }
                              //var dataParsed = JSON.parse(data);
                              //console.log(dataParsed);
                              showDATA();


                       },
                       error: function(xhr, status, error) {
                          // check status && error
                          alert(error);
                       }
                    });
            });

        $(document.body).on('click', '.del-btn-2', function(e){
            // do something here
                e.preventDefault();
                var arr = splitString(e.target.id);
                var id = arr[2];
                    $.ajax({
                        type: "post",
                        url: "src/postData.php",
                        data: {row_id: arr[2],action: "delnumber"},
                        dataType: "text",
                       success: function( data ) {
                              //var dataParsed = JSON.parse(data);
                              //console.log(dataParsed);
                              showDATA();


                       },
                       error: function(xhr, status, error) {
                          // check status && error
                          alert(error);
                       }
                    });
            });

        $(document.body).on('click', '.del-btn', function(e){
            // do something here
                e.preventDefault();
                var arr = splitString(e.target.id);
                var id = arr[2];
                    $.ajax({
                        type: "post",
                        url: "src/postData.php",
                        data: {ID: arr[2],action: "delperson"},
                        dataType: "text",
                       success: function( data ) {

                    $("#test-cont").html(data);
                              //var dataParsed = JSON.parse(data);
                              //console.log(dataParsed);
                              showDATA();


                       },
                       error: function(xhr, status, error) {
                          // check status && error
                          alert(error);
                       }
                    });
            });

        $(document).ready(function() {
            $(".add-btn").click(function(e) {
                e.preventDefault(); //add this line to prevent reload
                if(e.target.id=="add-name-btn")
                {
                    var fname = $("#add-name").val();
                    $.ajax({
                        type: "post",
                        url: "src/postData.php",
                        data: {name: fname, action: "addname"},
                        dataType: "text",
                       success: function( data ) {
                            if(data == "error : no input")
                            {
                               setPlaceholder("add-name","Enter a valid name!","#ffb2b2","white");
                            }
                            else
                            {
                              setPlaceholder("add-name","Enter a name!","white","#999999");
                              }
                               //var dataParsed = JSON.parse(data);
                              //console.log(dataParsed);
                              showDATA();

                       },
                       error: function(xhr, status, error) {
                          // check status && error
                          alert(error);
                       }
                    });
                }

            });
        });

    $(document).ready(function() {
            $("#logout").click(function(e) {
                e.preventDefault(); //add this line to prevent reload
                var loc = window.location.pathname;
                var dir = loc.substring(0, loc.lastIndexOf('/'));
                window.location = dir.concat("/src/logout.php");
               });
        });
    </script>
</html>
