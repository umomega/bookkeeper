Chart.defaults.global.responsive = true;
Chart.defaults.global.defaultFontFamily = '"Montserrat", sans-serif';
Chart.defaults.global.defaultFontColor = '#CCCCCC';
Chart.defaults.global.defaultFontStyle = 'bold';
Chart.defaults.global.defaultFontSize = 10;
Chart.defaults.global.tooltips.backgroundColor = '#263A8A';
Chart.defaults.global.tooltips.xPadding = 12;
Chart.defaults.global.tooltips.yPadding = 10;
Chart.defaults.global.tooltips.titleFontSize = 12;
Chart.defaults.global.tooltips.titleMarginBottom = 10;
Chart.defaults.global.legend.position = 'bottom';
Chart.defaults.global.legend.labels.boxWidth = 16;
Chart.defaults.global.legend.labels.padding = 32;
Chart.defaults.global.legend.labels.usePointStyle = true;
Chart.defaults.global.legend.labels.fontSize = 8;
Chart.defaults.global.legend.padding = 20;

window.chartDisplayDefaults = {
    fill: false,
    backgroundColor: "#FFFFFF",
    pointRadius: 6,
    pointHoverRadius: 8,
    pointBorderWidth: 1,
    borderWidth: 1,
};

window.chartColors = {
    "income": {
        pointBackgroundColor: "#26A65B",
        pointHoverBackgroundColor: "#26A65B",
        borderColor: "#26A65B",
        borderDash: []
    },
    "expense": {
        pointBackgroundColor: "#C0392B",
        pointHoverBackgroundColor: "#C0392B",
        borderColor: "#C0392B",
        borderDash: []
    },
    "income-i": {
        pointBackgroundColor: "#FFFFFF",
        pointHoverBackgroundColor: "#FFFFFF",
        borderColor: "#26A65B",
        borderDash: [2,2]
    },
    "expense-i": {
        pointBackgroundColor: "#FFFFFF",
        pointHoverBackgroundColor: "#FFFFFF",
        borderColor: "#C0392B",
        borderDash: [2,2]
    }
}
