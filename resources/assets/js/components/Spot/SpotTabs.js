import React, {Fragment} from 'react';
import Tabs from './Tabs';
import { BrowserRouter as Router, Route, Switch } from 'react-router-dom';
import Today from './Today';
import Forecast from './Forecast';
import Media from './Media';
import Reviews from './Reviews';

const SpotTabs = (props) => {
 return (
     <Fragment>
         <Router>
             <Fragment>
                 <Tabs path={props.path}/>
                 <Switch>
                     <Route exact path={`/${props.path}`} component={Today} />
                     <Route exact path={`/${props.path}/forecast`} component={Forecast} />
                     <Route exact path={`/${props.path}/media`} component={Media} />
                     <Route exact path={`/${props.path}/reviews`} component={Reviews} />
                 </Switch>
             </Fragment>
         </Router>
     </Fragment>
 )
}

export default SpotTabs;