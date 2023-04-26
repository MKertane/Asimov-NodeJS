// Récupérer les données du serveur
fetch('donneesNoteEleve.php')
.then(response => response.json())
.then(data => {
    // Extraire la liste des matières et leur moyenne de notes
    const labels = data.map(item => item.idMatiere);
    const values = data.map(item => item.moyenne);

    // Créer un graphique
    const ctx = document.getElementById('notesGraphique').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Moyenne des notes',
                data: values,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                      beginAtZero: true
                    }
                }]
            }
        }
    });
})
.catch(error => console.error(error));