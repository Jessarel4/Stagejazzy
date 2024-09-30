// src/components/chartBox/ChartBoxRistourneContainer1.tsx
import { useState, useEffect } from "react";
import axios from "axios";
import ChartBox from "./ChartBox";
import { formatNumber } from "../../utils/formatNumber"; // Assure-toi que le chemin est correct

const ChartBoxRistourneContainer1 = () => {
  const [chartData, setChartData] = useState<{ date: string; revenue: number }[]>([]);
  const [number, setNumber] = useState<number | string>(0);
  const [percentage, setPercentage] = useState<number>(0);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/ristournes");
        const data = response.data;

        // Convertir les données au format attendu
        const formattedData = data.map((item: { date: string; ristourne: number }) => ({
          date: item.date,
          revenue: item.ristourne,
        }));

        const totalRistourne = data.reduce((sum: number, item: { ristourne: number }) => sum + item.ristourne, 0);
        setNumber(formatNumber(totalRistourne)); // Utilise la fonction formatNumber
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
      color="purple"
      icon="/productIcon.svg"
      title="Total Ristourne"
      dataKey="revenue"
      number={number}
      percentage={percentage}
      chartData={chartData}
    />
  );
};

export default ChartBoxRistourneContainer1;
