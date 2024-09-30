import BarChartBox from "../../components/barChartBox/BarChartBox";
import BigChartBox from "../../components/bigChartBox/BigChartBox";
//import ChartBox from "../../components/chartBox/ChartBox";

import ChartBoxContainer from "../../components/chartBox/ChartBoxContainer";
import ChartBoxContainer1 from "../../components/chartBox/ChartBoxRistourneContainer1";
import ChartBoxRedevanceContainer2 from "../../components/chartBox/ChartBoxRedevanceContainer2";
import { LineChartBox } from "../../components/LineChartBox/LineChartBox";
import PieChartBox from "../../components/pieChartBox/PieChartBox";
import TopBox from "../../components/topBox/TopBox";
import "./home.scss"
import ChartBoxContainer3 from "../../components/chartBox/ChartBoxContainer3";

const Home = () => {
    return (
        <div className="home">
            <div className="box box1"><BarChartBox /></div>
            <div className="box box2"><ChartBoxContainer3 /></div>
            <div className="box box3"><ChartBoxRedevanceContainer2/></div>
            <div className="box box4"><TopBox/></div>
            <div className="box box5"><ChartBoxContainer1/></div>
            <div className="box box6"><ChartBoxContainer /> </div>
            <div className="box box7"><BigChartBox/></div>
            <div className="box box8"><LineChartBox /></div>
            <div className="box box9"><PieChartBox/></div>
        </div>
    );
}

export default Home;