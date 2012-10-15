function DagButtonClick (dag)
{
    if ($("#TijdKlikPopup").not(":hidden")) {
    $("#TijdKlikPopup").toggle(false);
    $(SelectedButton).css({background: "",
	color: ""});  
    }
    switch (dag) {
            case 'Vandaag':
                document.getElementById('Vandaagfilms').style.display = 'block';
                document.getElementById('Morgenfilms').style.display = 'none';
                document.getElementById('Overmorgenfilms').style.display = 'none';
                
                document.getElementById('vandaagButton').className = 'currentDate';
                document.getElementById('morgenButton').className = '';
                document.getElementById('overmorgenButton').className = '';
                break;
            case 'Morgen':
                document.getElementById('Vandaagfilms').style.display = 'none';
                document.getElementById('Morgenfilms').style.display = 'block';
                document.getElementById('Overmorgenfilms').style.display = 'none';
                
                document.getElementById('vandaagButton').className = '';
                document.getElementById('morgenButton').className = 'currentDate';
                document.getElementById('overmorgenButton').className = '';
                break;
            case 'Overmorgen':
                document.getElementById('Vandaagfilms').style.display = 'none';
                document.getElementById('Morgenfilms').style.display = 'none';
                document.getElementById('Overmorgenfilms').style.display = 'block';
                
                document.getElementById('vandaagButton').className = '';
                document.getElementById('morgenButton').className = '';
                document.getElementById('overmorgenButton').className = 'currentDate';
            default:
                break;
        }

}
