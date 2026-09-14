import React, { useState } from 'react';
import Chart from 'react-apexcharts';

const SuccessAnalyticsChart = () => {
  const [series] = useState([
    {
      name: 'Completed Tasks',
      data: [44, 55, 41, 67, 22, 43, 21]
    }
  ]);

  const [options] = useState({
    chart: {
      type: 'bar',
      toolbar: { show: false }
    },
    // ✅ Applied official Bootstrap 5 success green hex code
    colors: ['#198754'], 
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '45%',
        borderRadius: 4, // Clean slightly rounded corners
        dataLabels: { position: 'top' }
      }
    },
    dataLabels: {
      enabled: true,
      formatter: (val) => val,
      offsetY: -20,
      style: {
        fontSize: '12px',
        colors: ['#6c757d'] // Matches Bootstrap muted text color
      }
    },
    grid: {
      borderColor: '#dee2e6', // Matches Bootstrap border color
      strokeDashArray: 4,
      yaxis: { lines: { show: true } },
      xaxis: { lines: { show: false } }
    },
    xaxis: {
      categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      axisBorder: { show: false },
      axisTicks: { show: false },
      labels: {
        style: { colors: '#6c757d', fontSize: '14px' }
      }
    },
    yaxis: {
      labels: {
        style: { colors: '#6c757d', fontSize: '14px' }
      }
    },
    tooltip: {
      theme: 'light',
      y: {
        title: { formatter: (seriesName) => `${seriesName}:` }
      }
    }
  });

  return (
    <div className="card shadow-sm p-3" style={{ maxWidth: '600px', margin: '0 auto' }}>
      <div className="card-body">
        <h5 className="card-title text-success mb-4">Performance Metrics</h5>
        <Chart 
          options={options} 
          series={series} 
          type="bar" 
          height={350} 
          width="100%" 
        />
      </div>
    </div>
  );
};

export default SuccessAnalyticsChart;
