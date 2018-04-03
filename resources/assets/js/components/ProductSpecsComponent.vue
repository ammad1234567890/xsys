<template>
    <div>
        <div class="row">
            <div class="card headcolor">
                <div class="card-header">
                    <h3 class="card-title pad-bot">
                        <h4 class="heading-inline" style="text-transform: uppercase; "> Add Product Specification</h4> </h3>
                </div>
                <hr/>
            </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h2 class="panel-title">Product Specification</h2>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-2"><label>Phone Category</label></div>
                        <div class="col-md-3">
                            <select class="textbox_dropdown" required>
                                <option>Select Phone Category</option>

                            </select>
                        </div>
                        <div class="col-md-1"></div>

                        <div class="col-md-2"><label>Products</label></div>
                        <div class="col-md-3">
                            <select class="textbox_dropdown" required>
                                <option>Select Products</option>

                            </select>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                </div>

        </div>
    </div>
</template>

<script>
    import vSelect from "vue-select"
    export default {
        components: {vSelect},
        data() {
            return {}
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
        },
        methods: {

        }

    }
</script>