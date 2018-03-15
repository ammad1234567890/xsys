<template>
    <div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header">
                    <div class="icon icon-info">
                        <i class="material-icons">phonelink_setup</i>
                    </div>
                </div>
                <div class="card-content">
                    <p class="category"><strong>Active Product</strong></p>
                    <h3 class="card-title">1605</h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">dvr</i> <a href="#">View detailed</a>
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
