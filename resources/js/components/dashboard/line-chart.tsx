import React, { useState } from 'react';
import Chart from 'react-apexcharts';

const SuccessLineChart = () => {
  // 1. Define the line data values
  const [series] = useState([
    {
      name: 'Growth Rate',
      data: [45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10]
    }
  ]);

  // 2. Configure line styles and grid settings
  const [options] = useState({
    chart: {
      type: 'line',
      zoom: { enabled: false },
      toolbar: { show: false }
    },
    // Matches the same Bootstrap 5 success green used in your bar chart
    colors: ['var(--bs-success)'], 
    stroke: {
      curve: 'smooth', // Creates a sleek fluid curve instead of jagged lines
      width: 4        // Thickness of the line
    },
    markers: {
      size: 5,        // Size of the data point circles
      strokeColors: '#ffffff',
      strokeWidth: 2,
      hover: { size: 7 }
    },
    grid: {
      borderColor: '#dee2e6', // Matches standard Bootstrap border line styling
      strokeDashArray: 4,
      xaxis: { lines: { show: false } },
      yaxis: { lines: { show: true } }
    },
    xaxis: {
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      axisBorder: { show: false },
      axisTicks: { show: false },
      labels: {
        style: { colors: '#6c757d', fontSize: '13px' }
      }
    },
    yaxis: {
      labels: {
        style: { colors: '#6c757d', fontSize: '13px' }
      }
    },
    tooltip: {
      theme: 'light'
    }
  });

  return (
    <div className="card shadow-sm">
      <div className="card-body">
        <h5 className="card-title text-success mb-4 fs-6 fw-bolder">Daily Visits</h5>
        <Chart 
          options={options} 
          series={series} 
          type="line" 
          height={350} 
          width="100%" 
        />
      </div>
    </div>
  );
};

export default SuccessLineChart;
