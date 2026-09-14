import React, { useState } from 'react';
import Chart from 'react-apexcharts';

const DeviationChart = () => {
  // Two distinct series to control the positive and negative colors independently
  const [series] = useState([
    {
      name: 'Positive',
      // 18/08 has a darker shade as shown in your image
      data: [1.4, 2.6, { x: '18/08', y: 2.1, color: '#3F51B5' }, 3.5, 1.4, 0.9, 0]
    },
    {
      name: 'Negative',
      data: [-1.8, -1.1, -2.5, -1.5, -0.6, -1.8, 0]
    }
  ]);

  const [options] = useState({
    chart: {
      type: 'bar',
      stacked: true, // Enables the continuous column look across 0
      toolbar: { show: false },
      sparkline: { enabled: false }
    },
    // Matches the exact hex colors from your image
    colors: [
      ({ value, seriesIndex, dataPointIndex }) => {
        // Special condition for the darker blue bar on 18/08
        if (seriesIndex === 0 && dataPointIndex === 2) {
          return '#3B5998'; 
        }
        return seriesIndex === 0 ? '#5A82F6' : '#40C4FF';
      }
    ],
    plotOptions: {
      bar: {
        columnWidth: '20%', // Keeps the bars thin and sleek
        borderRadius: 8, // Gives the columns the distinct round capsule shape
        borderRadiusApplication: 'around', // Rounds both top and bottom edges
        borderRadiusWhenStacked: 'all'
      }
    },
    dataLabels: { enabled: false },
    legend: { show: false },
    grid: {
      show: true,
      borderColor: '#EAEAEA',
      strokeDashArray: 3, // Dotted horizontal grid lines
      xaxis: { lines: { show: false } }, // Hides vertical grid lines
      yaxis: { lines: { show: true } }
    },
    xaxis: {
      categories: ['16/08', '17/08', '18/08', '19/08', '20/08', '21/08', '22/08'],
      axisBorder: { show: false },
      axisTicks: { show: true, color: '#EAEAEA' },
      labels: {
        style: {
          colors: '#999999',
          fontSize: '13px'
        }
      }
    },
    yaxis: {
      min: -4.0,
      max: 4.0,
      tickAmount: 4, // Ensures increments of 2.0 (-4, -2, 0, 2, 4)
      labels: {
        formatter: (val) => val.toFixed(1),
        style: {
          colors: '#999999',
          fontSize: '13px'
        }
      }
    },
    tooltip: { enabled: true }
  });

  return (
    <div style={{ width: '100%', maxWidth: '600px', margin: '0 auto', padding: '20px' }}>
      <Chart 
        options={options} 
        series={series} 
        type="bar" 
        height={380} 
        width="100%" 
      />
    </div>
  );
};

export default DeviationChart;
