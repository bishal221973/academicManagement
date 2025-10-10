import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp, usePage } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import Swal from "sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        app.use(plugin).use(ZiggyVue).mount(el);

        // ✅ Global SweetAlert flash handler
        app.config.globalProperties.$inertia.on("finish", (event) => {
            const page = usePage();
            const flash = page.props.flash;
            if (flash?.success) {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "success",
                    title: flash.success,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            }

            if (flash?.error) {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "error",
                    title: flash.error,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            }
        });
    },
    progress: {
        color: "#4B5563",
    },
});
