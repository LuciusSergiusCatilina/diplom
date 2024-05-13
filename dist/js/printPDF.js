function printTable(tableData) {
    let printableWindow = window.open('', '_blank', 'width=800,height=600');

    let tableContent = '<table>';

    // Генерация HTML для заголовков таблицы
    tableContent += '<thead><tr>';
    Object.keys(tableData[0]).forEach(key => {
        if (key !== 'id_call' && key !== 'id_user' && key !== 'id_crew' && key !== 'id_patient' && key !== 'time') {
            tableContent += `<th>${key}</th>`;
        }
    });
    tableContent += '</tr></thead>';

    // Генерация HTML для тела таблицы
    tableContent += '<tbody>';
    tableData.forEach(row => {
        tableContent += '<tr>';
        Object.values(row).forEach(value => {
            tableContent += `<td>${value}</td>`;
        });
        tableContent += '</tr>';
    });
    tableContent += '</tbody>';

    tableContent += '</table>';

    let startDateInput = document.getElementById("startDate").value;
    let endDateInput = document.getElementById("endDate").value;

    moment.locale('ru');
    let startDate = moment(startDateInput).format('Do MMMM YYYY, h:mm ');
    let endDate = moment(endDateInput).format('Do MMMM YYYY, h:mm ');

    let printableContent = `
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Таблица вызовов</title>
 <style>
            body {
                padding: 20px;
                font-family: Arial, sans-serif;
            }
    
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
                border: 1px solid #dddddd;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
    
            th, td {
                border: 1px solid #dddddd;
                padding: 10px;
                text-align: left;
            }
    
            th {
                background-color: #f2f2f2;
                font-weight: bold;
                border-top: 2px solid #dddddd;
                border-bottom: 2px solid #dddddd;
            }
    
            td {
                border-bottom: 1px solid #dddddd;
            }
    
            tr:hover {
                background-color: #f2f2f2;
            }
    
            .table-header {
                background-color: #4CAF50;
                color: #fff;
                font-weight: bold;
                padding: 10px;
                border-radius: 10px 10px 0 0;
            }
    
            .table-footer {
                background-color: #4CAF50;
                color: #fff;
                font-weight: bold;
                padding: 10px;
                border-radius: 0 0 10px 10px;
            }
        </style>
    </head>
    <body>
    ${startDateInput || endDateInput ? `<h2>Записи в период с ${startDate ?? ""} до ${endDate ?? ""}</h2>` : ""}
    ${tableContent}
    </body>
    </html>
    `;

    printableWindow.document.write(printableContent);
    printableWindow.document.close();
    printableWindow.print();
}
