<template>
    <div class="row">
        <div>

        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {



            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        filters: {
            moment: function (date) {
                return moment(date).format('DD-MM-YYYY');
            }
        },
        created(){

        },
        methods: {

        }
    }
</script>
