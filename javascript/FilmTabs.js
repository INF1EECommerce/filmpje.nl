function TijdButtonCick(voorstellingId)
{
     var input = document.getElementById('voorstelling');
     input.value = voorstellingId;
     
     document.getElementById('voorstellingForm').submit();
}

function DagButtonClick (dag)
{
    switch (dag) {
            case 'Vandaag':
                document.getElementById('Vandaagfilms').style.visibility = 'visible';
                document.getElementById('Morgenfilms').style.visibility = 'collapse';
                document.getElementById('Overmorgenfilms').style.visibility = 'collapse';
                
                document.getElementById('vandaagButton').className = 'currentDate';
                document.getElementById('morgenButton').className = '';
                document.getElementById('overmorgenButton').className = '';
                break;
            case 'Morgen':
                document.getElementById('Vandaagfilms').style.visibility = 'collapse';
                document.getElementById('Morgenfilms').style.visibility = 'visible';
                document.getElementById('Overmorgenfilms').style.visibility = 'collapse';
                
                document.getElementById('vandaagButton').className = '';
                document.getElementById('morgenButton').className = 'currentDate';
                document.getElementById('overmorgenButton').className = '';
                break;
            case 'Overmorgen':
                document.getElementById('Vandaagfilms').style.visibility = 'collapse';
                document.getElementById('Morgenfilms').style.visibility = 'collapse';
                document.getElementById('Overmorgenfilms').style.visibility = 'visible';
                
                document.getElementById('vandaagButton').className = '';
                document.getElementById('morgenButton').className = '';
                document.getElementById('overmorgenButton').className = 'currentDate';
            default:
                break;
        }

}
