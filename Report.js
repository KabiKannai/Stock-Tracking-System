const reportForm = document.getElementById('reportForm');
const reportText = document.getElementById('reportText');
const reportsList = document.getElementById('reportsList');

// Function to save report to localStorage
function saveReportToLocalStorage(reportContent) {
    let reports = JSON.parse(localStorage.getItem('reports')) || [];
    reports.push(reportContent);
    localStorage.setItem('reports', JSON.stringify(reports));
}

// Function to load reports from localStorage
function loadReportsFromLocalStorage() {
    let reports = JSON.parse(localStorage.getItem('reports')) || [];
    reports.forEach(reportContent => {
        const reportElement = createReportElement(reportContent);
        reportsList.appendChild(reportElement);
    });
}

// Function to create report element
function createReportElement(reportContent) {
    const reportElement = document.createElement('div');
    reportElement.className = 'report';
    reportElement.textContent = reportContent;

    // Create delete button
    const deleteButton = document.createElement('button');
    deleteButton.className = 'delete-btn';
    deleteButton.textContent = 'Delete';

    // Style the delete button
    deleteButton.style.background = 'red';  // Sets the color to red
    deleteButton.style.marginLeft = '40px'; // Adjusts the margin to move it right
    deleteButton.style.color = 'white';

    deleteButton.addEventListener('click', function() {
        reportElement.remove();
        // Remove from localStorage
        removeReportFromLocalStorage(reportContent);
    });

    // Append delete button to report element
    reportElement.appendChild(deleteButton);

    return reportElement;
}


// Function to remove report from localStorage
function removeReportFromLocalStorage(reportContent) {
    let reports = JSON.parse(localStorage.getItem('reports')) || [];
    reports = reports.filter(report => report !== reportContent);
    localStorage.setItem('reports', JSON.stringify(reports));
}

// Event listener for form submission
reportForm.addEventListener('submit', function(event) {
    event.preventDefault();

    const reportContent = reportText.value.trim();

    if (reportContent !== '') {
        // Save report to localStorage
        saveReportToLocalStorage(reportContent);

        // Create report element and append
        const reportElement = createReportElement(reportContent);
        reportsList.appendChild(reportElement);

        // Clear input
        reportText.value = '';
    }
});

// Load existing reports from localStorage on page load
document.addEventListener('DOMContentLoaded', function() {
    loadReportsFromLocalStorage();
});
