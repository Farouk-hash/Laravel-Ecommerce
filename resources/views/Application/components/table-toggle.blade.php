<div class="d-flex justify-content-end align-items-center mb-4">
	<label id="toggleLabel" for="routeSwitch" class="me-2 mb-0" style="font-weight: 500; color: #444; padding-right: 5px;">
		{{ request()->routeIs('products.product_tables') ? 'Table View' : 'Grid View' }}
	</label>

	<input 
		type="checkbox" 
		id="routeSwitch"
		onchange="handleSwitch(this)"
		{{ request()->routeIs('products.product_tables') ? 'checked' : '' }}
		style="
			position: relative;
			width: 48px;
			height: 24px;
			appearance: none;
			background: {{ request()->routeIs('products.product_tables') ? '#28a745' : '#ccc' }};
			outline: none;
			border-radius: 999px;
			transition: background 0.3s;
			cursor: pointer;
		"
		oninput="
			this.style.background = this.checked ? '#28a745' : '#ccc';
			document.getElementById('toggleLabel').innerText = this.checked ? 'Grid View' : 'Table View';
		"
	>
</div>

<script>
	function handleSwitch(el) {
		if (el.checked) {
			window.location.href = "{{ route('products.product_tables') }}";
		} else {
			window.location.href = "{{ route('products') }}";
		}
	}
</script>

<style>
	#routeSwitch::before {
		content: '';
		position: absolute;
		width: 20px;
		height: 20px;
		border-radius: 50%;
		background: #fff;
		top: 2px;
		left: 2px;
		transition: transform 0.3s;
	}
	#routeSwitch:checked::before {
		transform: translateX(24px);
	}
</style>
