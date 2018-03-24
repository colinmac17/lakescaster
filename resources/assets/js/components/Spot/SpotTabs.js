import React, {Fragment} from 'react';
import Today from './Today';
import Forecast from './Forecast';
import Media from './Media';
import Reviews from './Reviews';

const SpotTabs = (props) => {
 return (
     <Fragment>
         <ul className="nav nav-tabs" id="myTab" role="tablist">
             <li className="nav-item">
                 <a className="nav-link active" id="home-tab" data-toggle="tab" href="#today" role="tab" aria-controls="today" aria-selected="true">Today</a>
             </li>
             <li className="nav-item">
                 <a className="nav-link" id="profile-tab" data-toggle="tab" href="#forecast" role="tab" aria-controls="forecast" aria-selected="false">Forecast</a>
             </li>
             <li className="nav-item disabled">
                 <a className="nav-link disabled" id="contact-tab" data-toggle="tab" href="#media" role="tab" aria-controls="media" aria-selected="false">Media <span className="badge badge-info">Comin Soon</span></a>
             </li>
             <li className="nav-item">
                 <a className="nav-link disabled" id="contact-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Reviews <span className="badge badge-info">Coming Soon</span></a>
             </li>
         </ul>
         <hr className="spot-nav-underline"/>
         <div className="tab-content" id="myTabContent">
             <div className="tab-pane fade show active" id="today" role="tabpanel" aria-labelledby="home-tab">
                <Today todayData={props.todayData}/>
             </div>
             <div className="tab-pane fade" id="forecast" role="tabpanel" aria-labelledby="profile-tab">
                <Forecast forecastData={props.forecastData}/>
             </div>
             <div className="tab-pane fade" id="media" role="tabpanel" aria-labelledby="contact-tab">
                <Media />
             </div>
             <div className="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="contact-tab">
                <Reviews />
             </div>
         </div>
     </Fragment>
 )
}

export default SpotTabs;