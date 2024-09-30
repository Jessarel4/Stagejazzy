// src/components/chartBox/ChartBoxRedevanceContainer2.tsx
import { useState, useEffect } from "react";
import axios from "axios";
import ChartBox from "./ChartBox";
import { formatNumber } from "../../utils/formatNumber"; // Assure-toi que le chemin est correct

const ChartBoxRedevanceContainer2 = () => {
  const [chartData, setChartData] = useState<{ date: string; revenue: number }[]>([]);
  const [number, setNumber] = useState<number | string>(0);
  const [percentage, setPercentage] = useState<number>(0);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/redevances");
        const data = response.data;

        // Convertir les données au format attendu
        const formattedData = data.map((item: { date: string; redevance: number }) => ({
          date: item.date,
          revenue: item.redevance,
        }));

        const totalRedevance = data.reduce((sum: number, item: { redevance: number }) => sum + item.redevance, 0);
        setNumber(formatNumber(totalRedevance)); // Utilise la fonction formatNumber
        setChartData(formattedData);

        // Exemple pourcentage, remplace-le par un calcul réel si nécessaire
        setPercentage(5); // Valeur par défaut, remplace avec un vrai calcul
      } catch (error) {
        console.error("Erreur lors du chargement des données:", error);
      }
    };

    fetchData();
  }, []);

  return (
    <ChartBox
      color="blue"
      icon="/userIcon.svg"
      
      title="Total Redevance"
      dataKey="revenue"
      number={number}
      percentage={percentage}
      chartData={chartData}
    />
  );
};

export default ChartBoxRedevanceContainer2;
