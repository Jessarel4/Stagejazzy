import React, { useState, useEffect } from "react";
import axios from "axios";
import {
  AreaChart,
  Area,
  XAxis,
  YAxis,
  Tooltip,
  ResponsiveContainer,
} from "recharts";
import "./bigChartBox.scss";
import moment from "moment";  // moment.js pour formater les dates

interface LpPerWeek {
  week: number;
  total: number;
}

interface LpPerMonth {
  month: number;
  total: number;
}

interface LpPerYear {
  year: number;
  total: number;
}

const BigChartBox: React.FC = () => {
  const [lpPerWeek, setLpPerWeek] = useState<LpPerWeek[]>([]);
  const [lpPerMonth, setLpPerMonth] = useState<LpPerMonth[]>([]);
  const [lpPerYear, setLpPerYear] = useState<LpPerYear[]>([]);
  const [view, setView] = useState<"week" | "month" | "year">("week");

  useEffect(() => {
    const fetchLpStats = async () => {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/lp-stats");
        setLpPerWeek(response.data.lpPerWeek);
        setLpPerMonth(response.data.lpPerMonth);
        setLpPerYear(response.data.lpPerYear);
      } catch (error) {
        console.error("Erreur lors de la récupération des données", error);
      }
    };
    fetchLpStats();
  }, []);

  // Fonction pour formater la date pour une semaine (exemple : "1 Jan - 7 Jan")
  const formatWeekLabel = (weekNumber: number) => {
    const yearStart = moment().startOf('year'); // début de l'année courante
    const startOfWeek = yearStart.add(weekNumber - 1, 'weeks').startOf('week'); // début de la semaine
    const endOfWeek = startOfWeek.clone().endOf('week'); // fin de la semaine
    return `${startOfWeek.format('DD MMM')} - ${endOfWeek.format('DD MMM')}`; // format des dates
  };

  // Fonction pour obtenir le nom du mois (exemple : "Janvier", "Février", etc.)
  const formatMonthLabel = (monthNumber: number) => {
    return moment().month(monthNumber - 1).format("MMMM"); // format mois
  };

  // Fonction pour afficher les données selon la vue sélectionnée
  const getData = () => {
    switch (view) {
      case "week":
        return lpPerWeek.map((item) => ({
          name: formatWeekLabel(item.week),
          total: item.total,
        }));
      case "month":
        return lpPerMonth.map((item) => ({
          name: formatMonthLabel(item.month),
          total: item.total,
        }));
      case "year":
        return lpPerYear.map((item) => ({
          name: `Année ${item.year}`,
          total: item.total,
        }));
      default:
        return [];
    }
  };

  return (
    <div className="bigChartBox">
      <h1>Statistiques des Laisser-Passer</h1>

      

      <div className="chart">
        <ResponsiveContainer width="99%" height={500}>
          <AreaChart
            data={getData()}
            margin={{
              top: 10,
              right: 30,
              left: 0,
              bottom: 0,
            }}
          >
            <XAxis dataKey="name" />
            <YAxis />
            <Tooltip />
            <Area
              type="monotone"
              dataKey="total"
              stroke="#8884d8"
              fill="#8884d8"
            />
          </AreaChart>
        </ResponsiveContainer>
      </div>


      {/* Boutons pour changer la vue */}
      <div className="buttons">
        <button onClick={() => setView("week")}>Voir par Semaine</button>
        <button onClick={() => setView("month")}>Voir par Mois</button>
        <button onClick={() => setView("year")}>Voir par Année</button>
      </div>



    </div>
  );
};

export default BigChartBox;
