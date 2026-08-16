
    const API = '/plant_monitor/dist/application/api/';
    const REFRESH = 5000;

    const chart = new Chart(document.getElementById('chart').getContext('2d'), {
      type: 'line',
      data: {
        labels: [],
        datasets: [{
            label: 'Temperature (°C)',
            data: [],
            borderColor: '#f97316',
            backgroundColor: 'rgba(249,115,22,.07)',
            tension: .4,
            fill: true,
            pointRadius: 3
          },
          {
            label: 'Humidity (%)',
            data: [],
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,.07)',
            tension: .4,
            fill: true,
            pointRadius: 3
          },
          {
            label: 'Soil Moisture (%)',
            data: [],
            borderColor: '#22c55e',
            backgroundColor: 'rgba(34,197,94,.07)',
            tension: .4,
            fill: true,
            pointRadius: 3
          }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            labels: {
              color: '#64748b',
              font: {
                size: 12
              }
            }
          }
        },
        scales: {
          x: {
            ticks: {
              color: '#94a3b8',
              font: {
                size: 11
              }
            },
            grid: {
              color: '#f1f5f9'
            }
          },
          y: {
            ticks: {
              color: '#94a3b8',
              font: {
                size: 11
              }
            },
            grid: {
              color: '#f1f5f9'
            },
            min: 0,
            max: 100
          }
        }
      }
    });

    async function fetchData() {
      try {
        const res = await fetch(`${API}get_data.php`);
        const data = await res.json();
        const l = data.latest;

        if (l) {
          document.getElementById('v-temp').textContent = parseFloat(l.temperature).toFixed(1);
          document.getElementById('v-hum').textContent = parseFloat(l.humidity).toFixed(1);
          document.getElementById('v-soil').textContent = l.soil_moisture;
          document.getElementById('soil-bar').style.width = l.soil_moisture + '%';

          const badge = document.getElementById('pump-badge');
          if (l.pump_status == 1) {
            badge.innerHTML = '<i class="bi bi-power me-1"></i> ON';
            badge.className = 'badge rounded-pill pump-on fs-6 px-3 py-2';
          } else {
            badge.innerHTML = '<i class="bi bi-power me-1"></i> OFF';
            badge.className = 'badge rounded-pill pump-off fs-6 px-3 py-2';
          }
          document.getElementById('pump-mode-lbl').textContent =
            'Mode: ' + (l.pump_mode === 'manual' ? 'Manual' : 'Auto');

          const alertEl = document.getElementById('alert-bar');
          alertEl.classList.toggle('d-none', l.soil_moisture >= 20);
          alertEl.classList.toggle('d-flex', l.soil_moisture < 20);
        }

        const h = data.history || [];
        chart.data.labels = h.map(r => new Date(r.created_at).toLocaleTimeString());
        chart.data.datasets[0].data = h.map(r => r.temperature);
        chart.data.datasets[1].data = h.map(r => r.humidity);
        chart.data.datasets[2].data = h.map(r => r.soil_moisture);
        chart.update('none');

        const tbody = document.getElementById('tbody');
        tbody.innerHTML = '';
        [...h].reverse().forEach(r => {
          tbody.innerHTML += `<tr>
        <td>${new Date(r.created_at).toLocaleTimeString()}</td>
        <td>${parseFloat(r.temperature).toFixed(1)}</td>
        <td>${parseFloat(r.humidity).toFixed(1)}</td>
        <td>${r.soil_moisture}</td>
        <td class="${r.pump_status==1?'status-on':'status-off'}">${r.pump_status==1?'ON':'OFF'}</td>
      </tr>`;
        });

        document.getElementById('ts-text').textContent = 'Updated: ' + new Date().toLocaleTimeString();

      } catch (e) {
        document.getElementById('ts-text').textContent = 'Connection error – retrying...';
      }
    }

    async function setPump(cmd) {
      const msg = document.getElementById('cmsg');
      try {
        const res = await fetch(`${API}set_pump_command.php`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `command=${cmd}`
        });
        const d = await res.json();
        if (d.status === 'success') {
          const labels = {
            on: '✅ Pump ON (Manual)',
            off: '🛑 Pump OFF (Manual)',
            auto: '🔄 Switched to Auto Mode'
          };
          msg.textContent = labels[cmd];
          msg.className = 'mt-2 small text-success fw-semibold';
          setTimeout(() => msg.textContent = '', 3000);
          fetchData();
        }
      } catch (e) {
        msg.textContent = '❌ Failed to send command';
        msg.className = 'mt-2 small text-danger fw-semibold';
      }
    }

    fetchData();
    setInterval(fetchData, REFRESH);
  