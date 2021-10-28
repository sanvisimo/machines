<template>
    <div class="flex h-full items-center"><span class="block alert w-1 h-full" :class="getColor"></span><span>{{ field.value }}</span></div>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
    computed: {
        getColor() {
           const diff = moment(this.field.value, 'YYYY-MM-DD').diff(moment(), 'days');
            console.log('diff',this.field.value,  diff);
            if(diff >= 5) {
                return "bg-red-600"
            }

            if(diff >= 3 ) {
                return "bg-yellow-500"
            }


        }
    }
}
</script>

<style scoped>
    .alert{
        width: 10px;
    }
</style>
