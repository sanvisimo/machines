<template>
    <div class="w-full">
      <div class="flex border-b border-40">
          <div class="py-4 w-1/4">
              <h4 class="font-normal text-80">{{ __(label) }}</h4>
          </div>
          <div class="py-4 break-words w-3/4">
              <p class="text-90">
                  {{ value }}
              </p>
          </div>
      </div>
    </div>
</template>

<script>
export default {
    name: "ComponentDetailField",
    props: ['label', 'value'],
}
</script>

<style scoped>

</style>
