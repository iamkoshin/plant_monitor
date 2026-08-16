// Initial state is handled by HTML d-none classes

$("#type").on("change", function () {
  if ($("#type").val() == 0) {
    $("#dateFromWrapper").addClass("d-none");
    $("#dateToWrapper").addClass("d-none");
    $("#from").val(""); // clear inputs on hide
    $("#to").val("");
  } else {
    $("#dateFromWrapper").removeClass("d-none");
    $("#dateToWrapper").removeClass("d-none");
  }
});

$("#statementForm").on("submit", function (event) {
  event.preventDefault();
  loadSensorReport();
});

function loadSensorReport() {
  let type = $("#type").val();
  let from = $("#from").val();
  let to = $("#to").val();

  if (type === "custom" && (from === "" || to === "")) {
    DisplayMessage(
      "error",
      "Please select both From and To dates for a custom range.",
    );
    return;
  }

  let sendingData = {
    type: type,
    from: from,
    to: to,
    action: "get_sensor_report",
  };

  // Show loading state on the button
  let $btn = $("#addNewBtn");
  $btn.prop("disabled", true).text("Loading...");

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "../api/sensor_report.php",
    data: sendingData,
    success: function (data) {
      let status = data.status;
      let response = data.data;
      let meta = data.meta || {};

      if (status) {
        renderSensorTable(response);
        renderReportInfo(meta, type, from, to);
      } else {
        renderSensorTable([]);
        DisplayMessage("error", response);
      }
    },
    error: function () {
      DisplayMessage(
        "error",
        "Unable to load sensor report. Please try again.",
      );
    },
    complete: function () {
      $btn.prop("disabled", false).text("Show Result");
    },
  });
}

function renderSensorTable(rows) {
  $("#statementTable thead").html("");
  $("#statementTable tbody").html("");

  if (rows.length === 0) {
    $("#statementTable thead").html("<tr><th>No data available</th></tr>");
    return;
  }

  const columns = [
    { key: "data_id", label: "ID" },
    { key: "temperature", label: "Temperature" },
    { key: "humidity", label: "Humidity" },
    { key: "soil_moisture", label: "Soil Moisture" },
    { key: "pump_status", label: "Pump" },
    { key: "created_at", label: "Time" },
  ];

  let headHtml = "<tr>";
  columns.forEach((col) => {
    headHtml += `<th>${col.label}</th>`;
  });
  headHtml += "</tr>";
  $("#statementTable thead").html(headHtml);

  let bodyHtml = "";
  rows.forEach((row) => {
    bodyHtml += "<tr>";
    columns.forEach((col) => {
      let value = row[col.key] ?? "";
      if (col.key === "pump_status") {
        value = String(value) === "1" ? "On" : "Off";
      }
      bodyHtml += `<td>${value}</td>`;
    });
    bodyHtml += "</tr>";
  });
  $("#statementTable tbody").html(bodyHtml);
}

function renderReportInfo(meta, type, from, to) {
  let total = meta.total_records || 0;
  let infoText = `Total records: ${total}`;
  if (type === "custom" && from && to) {
    infoText += ` | Filter: ${from} to ${to}`;
  }
  $("#reportInfo").text(infoText);
}

// Export all visible rows to CSV
$("#infoBtn").on("click", function () {
  // Check if table is empty or just has the placeholder row
  let firstRowColspan = $("#statementTable tbody tr:first td").attr("colspan");
  if ($("#statementTable tbody tr").length === 0 || firstRowColspan) {
    DisplayMessage("error", "No data to export. Please load a report first.");
    return;
  }

  let csvContent = "";
  
  // Get Headers
  let headers = [];
  $("#statementTable thead th").each(function () {
    headers.push('"' + $(this).text().replace(/"/g, '""') + '"');
  });
  csvContent += headers.join(",") + "\r\n";

  // Get Data Rows
  $("#statementTable tbody tr").each(function () {
    let rowData = [];
    $(this).find("td").each(function () {
      rowData.push('"' + $(this).text().replace(/"/g, '""') + '"');
    });
    csvContent += rowData.join(",") + "\r\n";
  });

  let file = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
  let url = URL.createObjectURL(file);
  let a = document.createElement("a");
  a.href = url;
  a.download = "sensor_report.csv";
  document.body.appendChild(a);
  a.click();
  document.body.removeChild(a);
});

function DisplayMessage(type, message) {
  let success = document.querySelector(".alert-success");
  let danger = document.querySelector(".alert-danger");

  if (type == "success") {
    if (success) {
      success.classList.remove("d-none");
      success.innerHTML = message;
    }
    if (danger) {
      danger.classList.add("d-none");
    }
    setTimeout(function () {
      if (success) {
        success.classList.add("d-none");
      }
    }, 3000);
  } else {
    if (danger) {
      danger.classList.remove("d-none");
      danger.innerHTML = message;
    }
    if (success) {
      success.classList.add("d-none");
    }
    setTimeout(function () {
      if (danger) {
        danger.classList.add("d-none");
      }
    }, 5000);
  }
}
