<template>
    <div>
        <div class="col-md-4">
            <div class="card" style="min-height: 350px">
                <div class="card-header card-header-icon">
                    <i class="material-icons">pie_chart</i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Warehouse-wise Sales
                    </h4>
                    <div id="jscharts-doughnut" class="chart chart-js-container">
                        <canvas id="doughnutChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>




