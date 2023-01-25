<template>
  <tr class="position-relative" :class="{ 'text-muted': (group && !group.enabled) }" data-bs-toggle="modal" data-bs-target="#groupEditModal" style="cursor: pointer" @click="handler(group)">
      <td>{{ group.id }}</td>
      <td>{{ group.title }}</td>
      <td :class="{ 'text-muted': (parent && !parent.enabled) }">{{ parent ? parent.title : '' }}</td>
      <td>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" :id="['enabled-' + group.id]" :checked="group.enabled > 0" disabled />
          <label class="form-check-label" :for="['enabled-' + group.id]" />
        </div>
      </td>
      <td><date-format :date="group.created_at"/></td>
			<td><date-format :date="group.updated_at"/></td>
  </tr>
  <template v-for="child of group.children">
    <group-table-row :group="child" :parent="group" :handler="handler"></group-table-row>
  </template>
</template>
 
<script>
	import DateFormat from '../DateFormat.vue';
	export default {
		components: {
			DateFormat,
    },
		props: [ 'group', 'parent', 'handler' ],
	};
</script>