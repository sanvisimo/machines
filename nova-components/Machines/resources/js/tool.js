import Tool from './components/Tool';
import ControlPlan from "./components/ControlPlan";
import ControlPlanConfigForm from "./components/ControlPlanConfigForm";
import ComponentConfig from "./components/ComponentConfig";
import ComponentConfigForm from "./components/ComponentConfigForm";

Nova.booting((Vue, router, store) => {
    Vue.component('machines', Tool);
    Vue.component('control-plan', ControlPlan);
    Vue.component('config-control-plan', ControlPlanConfigForm);
    Vue.component('component-config', ComponentConfig);
    Vue.component('component-config-form', ComponentConfigForm);
})
