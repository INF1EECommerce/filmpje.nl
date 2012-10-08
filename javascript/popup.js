  $(document).ready(function(){
                $('#EventAanmakenLink').click(function (event){
 
                    var url = $(this).attr("href");
                    var windowName = "popUp";//$(this).attr("name");
 
                    window.open(url, windowName, "width=580,height=420,scrollbars=1,resizable=0");
 
                    event.preventDefault();
 
                });
            });
