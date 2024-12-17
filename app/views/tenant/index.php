<head>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<!-- Filter Periode -->
<div class="bg-white p-3 rounded-md flex items-center space-x-3 cursor-pointer shadow-md relative hover:shadow-lg transition-shadow duration-300" id="filter-period">
  <i class="ti ti-calendar text-blue-500 text-lg"></i>
  <span class="text-gray-800">Filter Periode</span>
  <span class="text-gray-500" id="period-text">
    <?= isset($data['startDate']) && isset($data['endDate']) ? $data['startDate'] . ' - ' . $data['endDate'] : 'DD-MM-YYYY - DD-MM-YYYY'; ?>
  </span>
  <button class="text-blue-500 focus:outline-none">
    <i class="ti ti-chevron-down" id="chevron-icon"></i>
  </button>
</div>

<!-- Date Range Picker -->
<div class="hidden" id="date-range-picker" class="absolute mt-2 p-2 bg-white rounded-lg shadow-md z-50">
  <input type="date" name="startDate" id="startDate" class="p-2 border rounded-md" />
  <input type="date" name="endDate" id="endDate" class="p-2 border rounded-md" />
</div>

<!-- Apply Button -->
<button id="applyButton" class="hidden text-blue-500 mt-2 p-2 rounded border" onclick="applyDateFilter()">Apply</button>

<!-- Card Stats -->
<div class="grid grid-cols-4 gap-6">
  <div class="bg-white p-4 rounded-lg shadow flex items-center space-x-4">
    <div class="p-3 bg-blue-100 rounded-full">
      <i class="ti ti-file-invoice text-blue-500 text-2xl"></i>
    </div>
    <div>
      <p class="text-sm text-gray-500">Total Orders</p>
      <h3 class="text-xl font-semibold text-gray-800" id="totalOrders">0</h3>
    </div>
  </div>

  <div class="bg-white p-4 rounded-lg shadow flex items-center space-x-4">
    <div class="p-3 bg-yellow-100 rounded-full">
      <i class="ti ti-cash text-yellow-500 text-2xl"></i>
    </div>
    <div>
      <p class="text-sm text-gray-500">Total Revenue</p>
      <h3 class="text-xl font-semibold text-gray-800" id="totalRevenue">Rp0</h3>
    </div>
  </div>
</div>

<!-- Chart Section for Revenue -->
<div class="bg-white p-6 rounded-lg shadow-md mt-6 mb-6">
  <h2 class="text-lg font-semibold mb-4">Revenue Trend</h2>
  <canvas id="revenueChart" class="w-full"></canvas>
</div>

<script>
  // Toggle visibility of the date range picker
  const filterPeriodDiv = document.getElementById('filter-period');
  const dateRangePicker = document.getElementById('date-range-picker');
  const chevronIcon = document.getElementById('chevron-icon');
  const applyButton = document.getElementById('applyButton');
  const periodText = document.getElementById('period-text');

  filterPeriodDiv.addEventListener('click', () => {
    // Toggle visibility of the date range picker
    dateRangePicker.classList.toggle('hidden');

    // Rotate the chevron icon
    chevronIcon.classList.toggle('rotate-180');
  });

  // Detect changes in the date range inputs
  const startDateInput = document.getElementById('startDate');
  const endDateInput = document.getElementById('endDate');

  startDateInput.addEventListener('change', () => {
    handleDateSelection();
  });

  endDateInput.addEventListener('change', () => {
    handleDateSelection();
  });

  function handleDateSelection() {
    if (startDateInput.value && endDateInput.value) {
      applyButton.classList.remove('hidden');
      const startDateFormatted = formatDate(startDateInput.value);
      const endDateFormatted = formatDate(endDateInput.value);
      periodText.textContent = `${startDateFormatted} - ${endDateFormatted}`;
    }
  }

  function formatDate(date) {
    const [year, month, day] = date.split('-');
    return `${day}-${month}-${year}`;
  }

  function applyDateFilter() {
    const startDate = startDateInput.value;
    const endDate = endDateInput.value;

    const formattedStartDate = formatDate(startDate);
    const formattedEndDate = formatDate(endDate);

    console.log('Sending request with dates:', formattedStartDate, formattedEndDate);

    $.ajax({
      url: `/Tenant/getAnalytics/${formattedStartDate}/${formattedEndDate}`,
      method: 'GET',
      success: function(response) {
        console.log('Received data:', response);
        try {
          response = JSON.parse(response);
          $('#totalOrders').text(response.totalOrders);
          $('#totalRevenue').text('Rp' + response.totalRevenue);

          revenueChart.data.labels = response.chartLabels;
          revenueChart.data.datasets[0].data = response.chartData;
          revenueChart.update();

          dateRangePicker.classList.add('hidden');
          applyButton.classList.add('hidden');
        } catch (error) {
          console.error('Error parsing response:', error);
        }
      },
      error: function(xhr, status, error) {
        console.error('Error applying date filter:', error);
      }
    });
  }

  // Initialize the Revenue Trend chart with sample data
  const ctx = document.getElementById('revenueChart').getContext('2d');
  const revenueChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: [],
      datasets: [{
        label: 'Revenue (Rp)',
        data: [],
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 2,
        fill: true,
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        },
      },
    },
  });
</script>