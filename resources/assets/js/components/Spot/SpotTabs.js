import React, {Fragment} from 'react';
import Tabs from './Tabs';
import { BrowserRouter as Router, Route, Switch } from 'react-router-dom';
import Today from './Today';
import Forecast from './Forecast';
import Media from './Media';
import Reviews from './Reviews';

/*
    * Add ability to add props to Routes
    * Resource: https://github.com/ReactTraining/react-router/issues/4105
 */
const renderMergedProps = (component, ...rest) => {
    const finalProps = Object.assign({}, ...rest);
    return (
        React.createElement(component, finalProps)
    );
}

const PropsRoute = ({ component, ...rest }) => {
    return (
        <Route {...rest} render={routeProps => {
            return renderMergedProps(component, routeProps, rest);
        }}/>
    );
}
/*
    * End source
*/

const SpotTabs = (props) => {
 return (
     <Fragment>
         <Router>
             <Fragment>
                 <Tabs path={props.path}/>
                 <Switch>
                     <PropsRoute exact path={`/${props.path}`} component={Today} state={props.state} />
                     <PropsRoute exact path={`/${props.path}/forecast`} component={Forecast} state={props.state} />
                     <PropsRoute exact path={`/${props.path}/media`} component={Media} state={props.state} />
                     <PropsRoute exact path={`/${props.path}/reviews`} component={Reviews} state={props.state} />
                 </Switch>
             </Fragment>
         </Router>
     </Fragment>
 )
}

export default SpotTabs;