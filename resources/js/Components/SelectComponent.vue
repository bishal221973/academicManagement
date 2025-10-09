<template>
  <div class="dropdown w-full" :class="{ 'is-open': isOpen }" ref="dropdown">
    <!-- Dropdown button with label of the selected value -->
    <div class="dropdown-search ">
      <button type="button" @click="toggleDropdown" @keydown="onKeyDown" class="w-full text-left border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500">
        {{ selectedLabel ?? 'Select' }}
      </button>
    </div>

    <!-- Dropdown list -->
    <ul v-if="isOpen" class="dropdown-list w-full rounded-md relative">
      <!-- Search input to filter options -->
      <li class="p-2">
        <input
          v-model="searchQuery"
          type="text"
          placeholder="Search..."
          @input="filterOptions" 
          class="w-full rounded-md border-gray-300 focus:ring-2 focus:ring-blue-500"
        />
      </li>
      
      <!-- Filtered dropdown items -->
      <li
        v-for="(option, index) in filteredOptions"
        :key="index"
        class="dropdown-item"
        @click="selectOption(option)"
        :class="{'highlighted': index === highlightedIndex}"
      >
        {{ option.label }}
      </li>

      <!-- No results message -->
      <li v-if="filteredOptions.length === 0" class="dropdown-item no-results">
        No results found
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'DropdownWithSearch',
  props: {
    modelValue: {
      type: [String, Number],
      default: null,
    },
    options: {
      type: Array,
      required: true,
      validator(value) {
        return value.every(option => option.hasOwnProperty('label') && option.hasOwnProperty('value'));
      },
    },
  },
  data() {
    return {
      isOpen: false,
      searchQuery: '',
      highlightedIndex: -1,
      filteredOptions: this.options, // This will store the filtered options
    };
  },
  computed: {
    // Get the label corresponding to the modelValue
    selectedLabel() {
      const selectedOption = this.options.find(option => option.value === this.modelValue);
      return selectedOption ? selectedOption.label : null;
    },
  },
  watch: {
    modelValue(newVal) {
      this.highlightedIndex = this.getSelectedIndex(newVal);
    },
    options(newOptions) {
      this.filteredOptions = newOptions; // Update filtered options when options change
    },
  },
  methods: {
    toggleDropdown() {
      this.isOpen = !this.isOpen;
    },
    selectOption(option) {
      this.$emit('update:modelValue', option.value); // Emit the selected value
      this.isOpen = false; // Close the dropdown
      this.highlightedIndex = -1; // Reset highlighted index
    },
    getSelectedIndex(value) {
      return this.options.findIndex(option => option.value === value);
    },
    filterOptions() {
      // Filter options based on the search query
      const query = this.searchQuery.toLowerCase();
      this.filteredOptions = this.options.filter(option =>
        option.label.toLowerCase().includes(query)
      );
      this.highlightedIndex = -1; // Reset highlighted index when filtering
    },
    closeDropdownIfOutsideClick(event) {
      if (this.$refs.dropdown && !this.$refs.dropdown.contains(event.target)) {
        this.isOpen = false;
      }
    },
    onBlur() {
      // Close the dropdown after a slight delay to allow clicks inside
      setTimeout(() => {
        this.isOpen = false;
      }, 200);
    },
    onKeyDown(event) {
      if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
        if (!this.isOpen) {
          this.toggleDropdown(); // Open dropdown if it's closed
        }
        this.moveHighlight(event.key === 'ArrowDown' ? 1 : -1); // Move highlighted item up/down
        event.preventDefault(); // Prevent default scrolling behavior
      } else if (event.key === 'Enter' || event.key === ' ') {
        this.selectHighlightedOption(); // Select the highlighted option
        event.preventDefault(); // Prevent form submission or other default behavior
      }
    },
    moveHighlight(direction) {
      if (this.filteredOptions.length === 0) return; // Don't move if no options are available
      this.highlightedIndex = Math.min(
        Math.max(this.highlightedIndex + direction, 0),
        this.filteredOptions.length - 1
      );
    },
    selectHighlightedOption() {
      if (this.highlightedIndex >= 0 && this.highlightedIndex < this.filteredOptions.length) {
        const option = this.filteredOptions[this.highlightedIndex];
        this.selectOption(option); // Trigger option selection
      }
    },
  },
  mounted() {
    document.addEventListener('click', this.closeDropdownIfOutsideClick);
  },
  beforeUnmount() {
    document.removeEventListener('click', this.closeDropdownIfOutsideClick);
  },
};
</script>

<style scoped>
.dropdown {
  position: relative;
  display: inline-block;
}

.is-open .dropdown-list {
  display: block;
}

.dropdown-list {
  position: absolute;
  top: calc(100% + 3px);
  left: 0;
  width: 100%;
  background-color: white;
  border: 1px solid #ccc;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  list-style: none;
  margin: 0;
  padding: 0;
  z-index: 1;
}

.dropdown-item {
  padding: 10px;
  cursor: pointer;
}

.dropdown-item:hover {
  background-color: #f0f0f0;
}

.highlighted {
  background-color: #f0f0f0;
}

.dropdown-search input {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  margin-bottom: 8px;
  box-sizing: border-box;
}

.no-results {
  color: #999;
  padding: 10px;
  text-align: center;
}

.focus:ring-blue-500 {
  outline: none;
  box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
}
</style>
