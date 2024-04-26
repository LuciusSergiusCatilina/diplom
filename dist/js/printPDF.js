function printTable(tableName) {
    let printableWindow = window.open('', '_blank', 'width=800,height=600');
  
    let table = document.getElementById(tableName);
  
    let tableClone = table.cloneNode(true);
  
    tableClone.querySelectorAll('th#action').forEach(cell => cell.remove());
    tableClone.querySelectorAll('td#action').forEach(cell => cell.remove());
  
    let tableContent = tableClone.outerHTML;
    
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
    <h2>Записи в период с ${startDate} до ${endDate}</h2>
            ${tableContent}
    </body>
    </html>
    
  `;
  
    // Записываем HTML в окно печати
    printableWindow.document.write(printableContent);
  
    // Вызываем метод печати
    printableWindow.document.close();
    printableWindow.print();
  }
  