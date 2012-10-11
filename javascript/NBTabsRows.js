function NBClick (waarde)
{
    switch (waarde) {
            case 'Nu':
                document.getElementById('NuFilmsRows').style.display = 'block';
                document.getElementById('BinnenkortFilmsRows').style.display = 'none';
                document.getElementById('nuButton').className = 'currentDate';
                document.getElementById('binnenkortButton').className = '';
                break;
            case 'Binnenkort':
                document.getElementById('NuFilmsRows').style.display = 'none';
                document.getElementById('BinnenkortFilmsRows').style.display = 'block';
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




