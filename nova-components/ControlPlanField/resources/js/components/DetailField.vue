<template>
<!--    <panel-item :field="field" />-->
    <create-form
        @resource-created="handleResourceCreated"
        @cancelled-create="handleCancelledCreate"
        :mode="mode"
        resource-name="control-plans-config"
        :via-resource="resourceName"
        :via-resource-id="resourceId"
        via-relationship="controlPlanConfig"
        :should-override-meta="true"
    />
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
}
</script>
