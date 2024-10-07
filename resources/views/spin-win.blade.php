<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Spin Wheel App</title>
    <!-- Google Font -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap"
      rel="stylesheet"
    />
    <!-- Stylesheet -->
    <link rel="stylesheet" href="style.css" />
    <style>
      * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
      }
      body {
        height: 100vh;
        background: #FFDE59;
        max-width: 400px;
        margin: 0 auto;
      }
      .wrapper {
        width: 90%;
        max-width: 400px;
        max-height: 90vh;
        background-color: transparent;
        position: absolute;
        transform: translate(-50%, -50%);
        top: 440px;
        left: 50%;
        padding: 3em;
        border-radius: 1em;
        box-shadow: 0;
      }
      #final-value p {
        color: #2e3192;
      }
      .container {
        position: relative;
        width: 100%;
        height: 100%;
      }
      #wheel {
        max-height: inherit;
        width: inherit;
        top: 0;
        padding: 0;
      }
      @keyframes rotate {
        100% {
          transform: rotate(360deg);
        }
      }
      #spin-btn {
        position: absolute;
        transform: translate(-50%, -50%);
        top: 50%;
        left: 50%;
        height: 26%;
        width: 26%;
        border-radius: 50%;
        cursor: pointer;
        border: 0;
        background: radial-gradient(#fdcf3b 50%, #d88a40 85%);
        color: #c66e16;
        text-transform: uppercase;
        font-size: 1.8em;
        letter-spacing: 0.1em;
        font-weight: 600;
      }
      img.arrow {
        position: absolute;
        width: 4em;
        top: 45%;
        right: -9%;
      }
      #final-value {
        font-size: 12px;
        text-align: center;
        margin-top: 1.5em;
        color: #2e3192;
        font-weight: 500;
      }
      @media screen and (max-width: 768px) {
        .wrapper {
          font-size: 12px;
        }
        img.arrow {
          right: -5%;
        }
      }
      .strech {
        height: 100%;
        flex-direction: column;
        box-sizing: border-box;
        display: flex;
        place-content: stretch flex-start;
        align-items: stretch;
        max-width: 100%;
      }
      .logo {
        width: 100%;
        text-align: center;
        margin-top: 30px;
      }
      .logo img {
        max-width: 80%;
        margin: 0 auto;
      }
      h2.spinned p {
        color: green !important;
        font-size: 30px !important;
      }
    </style>
  </head>
  <body>
    <div class="strech">
      <div class="logo">
        <img src="{{ asset('resources/images/logo-2.png') }}" />
      </div>
      <div class="logo" style="margin-top: 0px">
        <img src="{{ asset('resources/images/spin-logo.png') }}" height="200px" />
      </div>
    </div>
    <div id="spin-wrapper" class="wrapper">
      <div id="spin-container" class="container">
        <canvas id="wheel"></canvas>
        <button id="spin-btn">Spin</button>
        <img class="arrow" src="{{ asset('resources/images/spin-arrow.png') }}" width="70" alt="spinner arrow" />
      </div>
      <div id="final-value">
        <p>Click On The Spin Button To Start</p>
      </div>
    </div>

    <!-- Chart JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <!-- Chart JS Plugin for displaying text over chart -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.1.0/chartjs-plugin-datalabels.min.js"></script>
    <!-- Script -->
    <script>
      const spinContainer = document.getElementById("spin-container");
      const spinWrapper = document.getElementById("spin-wrapper");
      const wheel = document.getElementById("wheel");
      const spinBtn = document.getElementById("spin-btn");
      const finalValue = document.getElementById("final-value");

      const rotationValues = [
        { minDegree: 0, maxDegree: 30, value: 2 },
        { minDegree: 31, maxDegree: 90, value: 1 },
        { minDegree: 91, maxDegree: 150, value: 6 },
        { minDegree: 151, maxDegree: 210, value: 5 },
        { minDegree: 211, maxDegree: 270, value: 4 },
        { minDegree: 271, maxDegree: 330, value: 3 },
        { minDegree: 331, maxDegree: 360, value: 2 },
      ];

      const data = [16, 16, 16, 16, 16, 16];
      var pieColors = ["#ed1c24", "#fff", "#ed1c24", "#fff", "#ed1c24", "#fff"];

      let myChart = new Chart(wheel, {
        plugins: [ChartDataLabels],
        type: "pie",
        data: {
          labels: [1, 2, 3, 4, 5, 6],
          datasets: [{ backgroundColor: pieColors, data: data }],
        },
        options: {
          responsive: true,
          animation: { duration: 0 },
          plugins: {
            tooltip: false,
            legend: { display: false },
            datalabels: {
              color: "#000",
              formatter: (_, context) => context.chart.data.labels[context.dataIndex],
              font: { size: 24 },
            },
          },
        },
      });

      let discount = null;

      const valueGenerator = (angleValue) => {
        for (let i of rotationValues) {
          if (angleValue >= i.minDegree && angleValue <= i.maxDegree) {
            let displayText = "";
            switch (i.value) {
              case 1: displayText = "Glass Set"; break;
              case 2: displayText = "Appa Chatty"; break;
              case 3: displayText = "Crakers Gift Box"; break;
              case 4: displayText = "Plastic Container Set"; break;
              case 5: displayText = "Hot Box"; break;
              case 6: displayText = "2Ltr Water Bottle "; break;
            }
            finalValue.innerHTML = `<h2 class="spinned">Congrats!!! You have won <br/> <p><b>${displayText}</b></p> </h2>`;
            discount = i.value;

            setTimeout(() => {
        const prize = encodeURIComponent(displayText);
        const url = `{{ route('thankYouPage') }}?prize=${prize}`;
        window.location.href = url;
      }, 3000);
            break;
          }
        }
      };

      let count = 0;
      let resultValue = 101;

      spinBtn.addEventListener("click", () => {
        spinBtn.disabled = true;
        finalValue.innerHTML = `<p>Good Luck! </p>`;

        let randomDegree = Math.floor(Math.random() * (355 - 0 + 1) + 0);

        let rotationInterval = setInterval(() => {
          myChart.options.rotation = myChart.options.rotation + resultValue;
          myChart.update();
          if (myChart.options.rotation >= 360) {
            count += 1;
            resultValue -= 5;
            myChart.options.rotation = 0;
          } else if (count > 15 && myChart.options.rotation == randomDegree) {
            valueGenerator(randomDegree);
            clearInterval(rotationInterval);
            count = 0;
            resultValue = 101;
          }
        }, 10);
      });
    </script>
  </body>
</html>
