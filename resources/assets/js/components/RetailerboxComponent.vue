
<template>
    <div>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header">
                    <div class="icon icon-warning">
                        <i class="material-icons">add_shopping_cart</i>
                    </div>
                </div>
                <div class="card-content">
                    <p class="category"><strong>Retailer Orders</strong></p>
                    <h3 class="card-title">500</h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">description</i>
                        <a href="#">View details </a>
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
