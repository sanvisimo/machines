<template>
    <div class="flex h-full items-center"><span class="block alert w-1 h-full mr-1" :class="getColor"></span><span>{{ value }}{{ expired }}</span></div>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
    data() {
      return {
          resource: null
      }
    },
    mounted() {
      this.fetchData();
    },
    computed: {
        expired() {
            if(this.resource && this.resource.active) {
                if (moment().isAfter(moment(this.field.value))) {
                    return " - " + this.__('Expired');
                }
            }
            return '';
        },
        getColor() {
            if(this.resource && this.resource.active) {
                if (moment().isAfter(moment(this.field.value))) {
                    return "bg-red-600"
                }

                if (moment(this.field.value).isSameOrBefore(moment().add(5, 'day'))) {
                    return "bg-yellow-500"
                }
            }

            return '';
        },

        value() {
            return moment(this.field.value).format('DD/MM/YYYY');
        }
    },
    methods: {
        async fetchData() {
            const { data } = await Nova.request().get(`/nova-vendor/akka-date/date/${this.$attrs.resource.id.value}/${this.resourceName}`);
            this.resource = data.resource
        }
    }
}
</script>

<style scoped>
    .alert{
        width: 10px;
    }
</style>
