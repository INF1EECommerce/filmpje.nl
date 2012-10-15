function NBClick (waarde)
{
    switch (waarde) {
            case 'Nu':
                document.getElementById('NuFilms').style.display = 'block';
                document.getElementById('NuFilmsRows').style.display = 'block';
                document.getElementById('BinnenkortFilms').style.display = 'none';
                document.getElementById('BinnenkortFilmsRows').style.display = 'none';
                document.getElementById('nuButton').className = 'currentDate';
                document.getElementById('binnenkortButton').className = '';
                break;
            case 'Binnenkort':
                document.getElementById('NuFilms').style.display = 'none';
                document.getElementById('NuFilmsRows').style.display = 'none';
                document.getElementById('BinnenkortFilms').style.display = 'block';
                document.getElementById('BinnenkortFilmsRows').style.display = 'block';
                document.getElementById('binnenkortButton').className = 'currentDate';
                document.getElementById('nuButton').className = '';
                break;
            default:
                break;
        }

}

$(document).ready(function() {
    $('#Rows').toggle(false); 
});

function SwitchView()
{
    
 if ($("#Tiles").is(":visible")) {   
 $('#Tiles').toggle("drop", { direction: "down" }, 200, function()
{
     $('#Rows').toggle("drop", { direction: "down" }, 200);
}
);
 } 
 else
  {
  $('#Rows').toggle("drop", { direction: "down" }, 200, function()
{
    $('#Tiles').toggle("drop", { direction: "down" }, 200);
} 
);
  }
    
}




