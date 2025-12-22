<script setup>
import { onMounted, ref, watch } from 'vue'
import {
  Chart,
  LineController,
  LineElement,
  PointElement,
  CategoryScale,
  LinearScale,
  Tooltip,
  Legend
} from 'chart.js'

Chart.register(
  LineController,
  LineElement,
  PointElement,
  CategoryScale,
  LinearScale,
  Tooltip,
  Legend
)

const props = defineProps({
  courseStudents: {
    type: Array,
    required: true
  }
})

const chartRef = ref(null)
let chartInstance = null

const renderChart = () => {
  if (!props.courseStudents.length) return

  const labels = props.courseStudents.map(item => item.name)
  const data = props.courseStudents.map(item => item.students_count)

  if (chartInstance) chartInstance.destroy()

  chartInstance = new Chart(chartRef.value, {
    type: 'line',
    data: {
      labels,
      datasets: [
        {
          label: 'Students per Course',
          data,
          borderWidth: 2,
          tension: 0.4,

          // 🎨 COLORS
          borderColor: '#2563eb',          // line color (blue)
          backgroundColor: 'rgba(37,99,235,0.2)', // fill color
          pointBackgroundColor: '#2563eb',
          pointBorderColor: '#ffffff',
          pointHoverBackgroundColor: '#1e40af',
          pointHoverBorderColor: '#ffffff',

          pointRadius: 4,
          pointHoverRadius: 6,
          fill: true
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          labels: {
            font: { size: 10 }
          }
        },
        tooltip: {
          bodyFont: { size: 9 },
          titleFont: { size: 10 }
        }
      },
      scales: {
        x: {
          ticks: {
            font: { size: 6 }
          }
        },
        y: {
          beginAtZero: true,
          ticks: {
            font: { size: 13 }
          }
        }
      }
    }
  })
}

onMounted(renderChart)
watch(() => props.courseStudents, renderChart, { deep: true })
</script>

<template>
  <div class="w-full">
    <canvas ref="chartRef"></canvas>
  </div>
</template>
