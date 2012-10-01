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
