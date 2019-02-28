<template>
    <div>
        <div class="col-md-8">
            <div class="card" style="min-height: 350px">
                <div class="card-header card-header-icon">
                    <i class="material-icons">timeline</i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Sales Report
                    </h4>
                    <div class="chart-edge">
                        <div class="chart chart-js-container">
                            <canvas id="barChart"></canvas>
                        </div>
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
