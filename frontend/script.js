document.getElementById('sendButton').addEventListener('click', async () => {
  const question = document.getElementById('questionInput').value;
  if (!question) return;

  document.getElementById('sqlQuery').textContent = 'Gerando consulta SQL...';
  document.getElementById('resultTable').innerHTML = 'Carregando...';

  try {
    const response = await fetch('/backend/index.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ question: question })
    });
    const data = await response.json();

    if (data.success) {
      document.getElementById('sqlQuery').textContent = data.sql;

      const tableHtml = generateTable(data.data);
      document.getElementById('resultTable').innerHTML = tableHtml;

    } else {
      document.getElementById('sqlQuery').textContent = '';
      document.getElementById('resultTable').innerHTML = `<p class="error">${data.error}</p>`;
    }
  } catch (error) {
    document.getElementById('sqlQuery').textContent = '';
    document.getElementById('resultTable').innerHTML = `<p class="error">Erro ao conectar com o servidor: ${error}.</p>`;
  }
});

function generateTable(data) {
  if (!data || data.length === 0) return '<p>Nenhum resultado encontrado.</p>';

  let html = '<table><thead><tr>';
  const headers = Object.keys(data[0]);
  headers.forEach(header => {
    html += `<th>${header}</th>`;
  });
  html += '</tr></thead><tbody>';

  data.forEach(row => {
    html += '<tr>';
    headers.forEach(header => {
      html += `<td>${row[header]}</td>`;
    });
    html += '</tr>';
  });
  html += '</tbody></table>';
  return html;
}
