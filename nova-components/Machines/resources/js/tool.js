import Tool from './components/Tool';
import ControlPlan from "./components/ControlPlan";
import ControlPlanConfigForm from "./components/ControlPlanConfigForm";
import ComponentConfig from "./components/ComponentConfig";
import ComponentConfigForm from "./components/ComponentConfigForm";

/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'

/* import specific icons */
import { faFileImage, faFilePdf } from '@fortawesome/free-solid-svg-icons'

/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

/* add icons to the library */
library.add(faFileImage, faFilePdf)

Nova.booting((Vue, router, store) => {
    /* add font awesome icon component */
    Vue.component('font-awesome-icon', FontAwesomeIcon)

    Vue.component('machines', Tool);
    Vue.component('control-plan', ControlPlan);
    Vue.component('config-control-plan', ControlPlanConfigForm);
    Vue.component('component-config', ComponentConfig);
    Vue.component('component-config-form', ComponentConfigForm);
})
