import { useEffect, useState } from "react";
import { Bar, BarChart, ResponsiveContainer, Tooltip, XAxis, YAxis, Legend } from "recharts";
import axios from "axios";
import "./barChartBox.scss";

type ChartData = {
  nom_direction: string;
  total_redevance: number;
  total_ristourne: number;
  total_revenu: number;
  quantite_en_lettre: string; // Corrigé pour correspondre à la réponse du backend
  startDate: string;
  endDate: string;
};

const formatNumber = (number: number) => {
  if (number >= 1000000) {
    return (number / 1000000).toFixed(1) + "M";
  } else if (number >= 1000) {
    return (number / 1000).toFixed(1) + "k";
  }
  return number.toString();
};

const BarChartBox = () => {
  const [chartData, setChartData] = useState<ChartData[]>([]);
  const [period, setPeriod] = useState("week");
  const [offset, setOffset] = useState(0);
  const [startDate, setStartDate] = useState<string | null>(null);
  const [endDate, setEndDate] = useState<string | null>(null);

  const fetchChartData = (selectedPeriod: string, offsetVal?: number) => {
    axios
      .get("http://127.0.0.1:8000/api/getTopDirectionsByPeriod", {
        params: { period: selectedPeriod, offset: offsetVal }
      })
      .then((response) => {
        setChartData(response.data);

        // Mise à jour des dates de la période
        if (response.data.length > 0) {
          setStartDate(response.data[0].startDate);
          setEndDate(response.data[0].endDate);
        } else {
          setStartDate(null);
          setEndDate(null);
        }
      })
      .catch((error) => {
        console.error("Erreur lors du chargement des données:", error);
      });
  };

  useEffect(() => {
    fetchChartData(period, offset);
  }, [period, offset]);

  const renderTooltipContent = (props: any) => {
    const { active, payload } = props;
    if (active && payload && payload.length) {
      const { nom_direction, quantite_en_lettre, startDate, endDate } = payload[0]?.payload || {};
      const data = payload[0]?.payload;
      return (
        <div style={{ background: "#2a3447", borderRadius: "5px", padding: "10px", color: "#fff" }}>
          <div style={{ fontWeight: "bold", fontSize: "14px" }}>
            {startDate} - {endDate}
          </div>
          <div style={{ fontWeight: "bold", fontSize: "14px" }}>{nom_direction}</div>
          <div>
            <div><strong>Redevance:</strong> {data.total_redevance.toLocaleString()}</div>
            <div><strong>Ristourne:</strong> {data.total_ristourne.toLocaleString()}</div>
            <div><strong>Revenu Total:</strong> {data.total_revenu.toLocaleString()}</div>
            <div><strong>Quantité (lettre):</strong> {quantite_en_lettre}</div> {/* Utiliser quantite_en_lettre */}
          </div>
        </div>
      );
    }
    return null;
  };

  return (
    <div className="barChartBox">
      <h1>Top 3 Directions</h1>
      
      <div className="date">
        Période : <span className="res">{startDate && endDate ? `${startDate} au ${endDate}` : "Période actuelle"}</span>
      </div>

      <div className="chart-controls">
        <button onClick={() => setPeriod("week")}>Semaine</button>
        <button onClick={() => setPeriod("month")}>Mois</button>
        <button onClick={() => setPeriod("year")}>Année</button>
      </div>

      <div className="chart">
        <ResponsiveContainer width="100%" height={300}>
          <BarChart data={chartData} margin={{ bottom: 50 }}>
            <XAxis dataKey="nom_direction" tick={{ fontSize: 12 }} angle={-45} textAnchor="end" interval={0} />
            <YAxis tickFormatter={formatNumber} />
            <Tooltip content={renderTooltipContent} />
            <Legend layout="horizontal" verticalAlign="top" align="center" wrapperStyle={{ paddingBottom: 20 }} />
            <Bar dataKey="total_redevance" fill="#8884d8" name="Redevance" />
            <Bar dataKey="total_ristourne" fill="#82ca9d" name="Ristourne" />
            <Bar dataKey="total_revenu" fill="#ffc658" name="Revenu Total" />
          </BarChart>
        </ResponsiveContainer>
      </div>

      <div className="offset-controls">
        <button onClick={() => setOffset((prev) => prev - 1)}>{"<<"}</button>
        <button onClick={() => setOffset(0)}>Actualiser</button>
        <button onClick={() => setOffset((prev) => prev + 1)}>{">>"}</button>
      </div>
    </div>
  );
};

export default BarChartBox;
