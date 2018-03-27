import React, {Fragment} from 'react';
import { Link } from 'react-router-dom';

const path = window.location.pathname;

const Tabs = (props) => {
    return (
        <Fragment>
            <ul className="nav" id="spot-nav-links">
                <li className="nav-item">
                    <Link data-path="today" className={path === `/${props.path}` ? 'nav-link active' : 'nav-link'} to={`/${props.path}`}>Today</Link>
                </li>
                <li className="nav-item">
                    <Link data-path="forecast" className={path === `/${props.path}/forecast` ? 'nav-link active' : 'nav-link'} to={`/${props.path}/forecast`}>Forecast</Link>
                </li>
                <li className="nav-item">
                    <Link data-path="media" className={path === `/${props.path}/media` ? 'nav-link active' : 'nav-link'} to={`/${props.path}/media`}>Media</Link>
                </li>
                <li className="nav-item">
                    <Link data-path="reviews" className={path === `/${props.path}/reviews` ? 'nav-link active' : 'nav-link'} to={`/${props.path}/reviews`}>Reviews</Link>
                </li>
            </ul>
            <hr className="spot-nav-underline"/>
        </Fragment>

    )
}

export default Tabs;