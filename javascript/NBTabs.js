function NBClick (waarde)
{
    switch (waarde) {
            case 'Nu':
                document.getElementById('NuFilms').style.display = 'block';
                document.getElementById('BinnenkortFilms').style.display = 'none';
                document.getElementById('nuButton').className = 'currentDate';
                document.getElementById('binnenkortButton').className = '';
                break;
            case 'Binnenkort':
                document.getElementById('NuFilms').style.display = 'none';
                document.getElementById('BinnenkortFilms').style.display = 'block';
                document.getElementById('binnenkortButton').className = 'currentDate';
                document.getElementById('nuButton').className = '';
                break;
            default:
                break;
        }

}

function SwitchView()
{
    
 
    
}




