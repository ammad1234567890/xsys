<style lang="scss">
#DataTable tr td{
   padding:10px;
}
#DataTable tr th{
   font-size:15px;
   padding:10px;
}
</style>

<template>
    <table class="display table-bordered" style="width:100%" id="DataTable">
            <thead>
                <tr>
                    <th v-for="column in columns" :key="column.name" @click="$emit('sort', column.name)"
                        :class="sortKey === column.name ? (sortOrders[column.name] > 0 ? 'sorting_asc' : 'sorting_desc') : 'sorting'"
                        :style="'width:'+column.width+';'+'cursor:pointer;'">
                        {{column.label}}
                    </th>
                </tr>
            </thead>
            <slot></slot>
    </table>
</template>

<script>
    export default{
        props: ['columns', 'sortKey', 'sortOrders'],
    }
</script>