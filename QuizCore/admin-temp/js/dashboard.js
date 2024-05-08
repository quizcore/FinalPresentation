/* globals Chart:false */

(() => {
  'use strict'

// Get the canvas element
var ctx = document.getElementById('myChart').getContext('2d');

// Define the data
var data = {
  labels: ['110', '111', 'NONE'],
  datasets: [{
    data: [30, 40, 30], // Sample data, you can replace with your own values
    backgroundColor: [
      'rgba(255, 99, 132, 0.6)', // Red
      'rgba(54, 162, 235, 0.6)', // Blue
      'rgba(255, 206, 86, 0.6)' // Yellow
    ],
    borderColor: [
      'rgba(255, 99, 132, 1)',
      'rgba(54, 162, 235, 1)',
      'rgba(255, 206, 86, 1)'
    ],
    borderWidth: 1
  }]
};

// Define options
var options = {
  // Add a legend to the chart
  legend: {
    position: 'right' // Adjust position as needed
  },
  // Add labels inside the doughnut chart
  plugins: {
    labels: {
      render: 'percentage', // Display percentages
      precision: 0, // Number of decimal places for percentages
      fontSize: 14, // Font size of labels
      fontColor: '#fff', // Font color of labels
      fontStyle: 'bold', // Font style of labels
      fontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif" // Font family of labels
    }
  }
};

// Create the doughnut chart
var myChart = new Chart(ctx, {
  type: 'doughnut',
  data: data,
  options: options
})
})()
