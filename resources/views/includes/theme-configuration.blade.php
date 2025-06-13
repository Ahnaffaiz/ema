<div class="hidden">
    <div class="fixed inset-0 z-40 transition-opacity bg-black/40"></div>
    <div class="fixed right-0 z-50 h-screen bg-white w-80" data-simplebar>
        <div class="flex items-center p-4 border-b border-gray-100">
            <h5 class="m-0 mr-2">Theme Customizer</h5>
            <a href="javascript:void(0);" class="w-6 h-6 ml-auto text-center bg-gray-700 rounded-full">
                <i class="leading-relaxed text-white align-middle mdi mdi-close text-15"></i>
            </a>
        </div>
        <div class="p-4">
            <h6 class="mb-3">Layout</h6>
            <div class="flex gap-4">
                <div>
                    <input class="focus:ring-0" checked type="radio" name="layout" id="layout-vertical" value="vertical">
                    <label class="align-middle" for="layout-vertical">Vertical</label>
                </div>
                <div>
                    <input class="focus:ring-0" type="radio" name="layout" id="layout-horizontal" value="horizontal">
                    <label class="align-middle" for="layout-horizontal">Horizontal</label>
                </div>
            </div>

            <h6 class="pt-2 mt-4 mb-3">Layout Mode</h6>
            <div class="flex gap-4">
                <div>
                    <input class="focus:ring-0" checked type="radio" name="layout-mode" id="layout-mode-light" value="light">
                    <label class="form-check-label" for="layout-mode-light">Light</label>
                </div>
                <div>
                    <input class="focus:ring-0" type="radio" name="layout-mode" id="layout-mode-dark" value="dark">
                    <label class="form-check-label" for="layout-mode-dark">Dark</label>
                </div>
            </div>

            <h6 class="pt-2 mt-4 mb-3">Layout Width</h6>

            <div class="flex gap-4">
                <div>
                    <input class="focus:ring-0" checked type="radio" name="layout-width" id="layout-width-fuild" value="fuild" onchange="document.body.setAttribute('data-layout-size', 'fluid')">
                    <label class="form-check-label" for="layout-width-fuild">Fluid</label>
                </div>
                <div>
                    <input class="focus:ring-0" type="radio" name="layout-width" id="layout-width-boxed" value="boxed" onchange="document.body.setAttribute('data-layout-size', 'boxed')">
                    <label class="form-check-label" for="layout-width-boxed">Boxed</label>
                </div>
            </div>

            <h6 class="pt-2 mt-4 mb-3">Layout Position</h6>
            <div class="flex gap-4">
                <div>
                    <input class="focus:ring-0" checked type="radio" name="layout-position" id="layout-position-fixed" value="fixed" onchange="document.body.setAttribute('data-layout-scrollable', 'false')">
                    <label class="form-check-label" for="layout-position-fixed">Fixed</label>
                </div>
                <div>
                    <input class="focus:ring-0" checked type="radio" name="layout-position" id="layout-position-scrollable" value="scrollable" onchange="document.body.setAttribute('data-layout-scrollable', 'true')">
                    <label class="form-check-label" for="layout-position-scrollable">Scrollable</label>
                </div>
            </div>

            <h6 class="pt-2 mt-4 mb-3">Topbar Color</h6>
            <div class="flex gap-4">
                <div>
                    <input class="focus:ring-0" checked type="radio" name="topbar-color" id="topbar-color-light" value="light" onchange="document.body.setAttribute('data-topbar', 'light')">
                    <label class="form-check-label" for="topbar-color-light">Light</label>
                </div>
                <div>
                    <input class="focus:ring-0" type="radio" name="topbar-color" id="topbar-color-dark" value="dark" onchange="document.body.setAttribute('data-topbar', 'dark')">
                    <label class="form-check-label" for="topbar-color-dark">Dark</label>
                </div>
            </div>

            <h6 class="pt-2 mt-4 mb-3 sidebar-setting">Sidebar Size</h6>

            <div class="space-y-1">
                <div class="form-check sidebar-setting">
                    <input class="focus:ring-0" checked type="radio" name="sidebar-size" id="sidebar-size-default" value="default" onchange="document.body.setAttribute('data-sidebar-size', 'lg')">
                    <label class="form-check-label" for="sidebar-size-default">Default</label>
                </div>
                <div class="form-check sidebar-setting">
                    <input class="focus:ring-0" type="radio" name="sidebar-size" id="sidebar-size-compact" value="compact" onchange="document.body.setAttribute('data-sidebar-size', 'md')">
                    <label class="form-check-label" for="sidebar-size-compact">Compact</label>
                </div>
                <div class="form-check sidebar-setting">
                    <input class="focus:ring-0" type="radio" name="sidebar-size" id="sidebar-size-small" value="small" onchange="document.body.setAttribute('data-sidebar-size', 'sm')">
                    <label class="form-check-label" for="sidebar-size-small">Small (Icon View)</label>
                </div>
            </div>

            <h6 class="pt-2 mt-4 mb-3 sidebar-setting">Sidebar Color</h6>
            <div class="space-y-1">
                <div class="form-check sidebar-setting">
                    <input class="focus:ring-0" checked type="radio" name="sidebar-color" id="sidebar-color-light" value="light" onchange="document.body.setAttribute('data-sidebar', 'light')">
                    <label class="form-check-label" for="sidebar-color-light">Light</label>
                </div>
                <div class="form-check sidebar-setting">
                    <input class="focus:ring-0" type="radio" name="sidebar-color" id="sidebar-color-dark" value="dark" onchange="document.body.setAttribute('data-sidebar', 'dark')">
                    <label class="form-check-label" for="sidebar-color-dark">Dark</label>
                </div>
                <div class="form-check sidebar-setting">
                    <input class="focus:ring-0" type="radio" name="sidebar-color" id="sidebar-color-brand" value="brand" onchange="document.body.setAttribute('data-sidebar', 'brand')">
                    <label class="form-check-label" for="sidebar-color-brand">Brand</label>
                </div>
            </div>

            <h6 class="pt-2 mt-4 mb-3">Direction</h6>
            <div class="space-y-1">
                <div>
                    <input class="focus:ring-0" checked type="radio" name="layout-direction" id="layout-direction-ltr" value="ltr">
                    <label class="form-check-label" for="layout-direction-ltr">LTR</label>
                </div>
                <div>
                    <input class="focus:ring-0" type="radio" name="layout-direction" id="layout-direction-rtl" value="rtl">
                    <label class="form-check-label" for="layout-direction-rtl">RTL</label>
                </div>
            </div>

        </div>
    </div>
</div>
