<template>
    <div>
        <div class="col-md-12">
            <div class="card" >
                <div class="card-header card-header-icon">
                    <i class="material-icons">view_list</i>
                </div>
                <div class="card-content">
                    <h4 class="card-title">Stock Stats</h4>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead class="text-primary ">
                                <tr>
                                    <th>S.no</th>
                                    <th>Model</th>
                                    <th>Color</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Xcell - Nova</td>
                                    <td>Met-Black</td>
                                    <td>100</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Xcell - Nova</td>
                                    <td>Gold</td>
                                    <td>150</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Xcell - Nova Plus</td>
                                    <td>Rose Gold</td>
                                    <td>150</td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Xcell - Nova Plus</td>
                                    <td>Met-Black</td>
                                    <td>200</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Xcell - Zoom</td>
                                    <td>Black</td>
                                    <td>200</td>
                                </tr>
                            </tbody>
                        </table>
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
