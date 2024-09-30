import { useState, useEffect } from "react";
import axios from "axios";
import ChartBox from "./ChartBox";
import { formatNumber } from "../../utils/formatNumber"; // Assurez-vous que le chemin est correct

const ChartBoxContainer = () => {
  const [chartData, setChartData] = useState<{ date: string; revenue: number }[]>([]);
  const [totalRevenue, setTotalRevenue] = useState<number | string>(0);
  const [percentage, setPercentage] = useState<number>(0);
  const [view, setView] = useState<'week' | 'month'>('week'); // État pour gérer la vue

  useEffect(() => {
    const fetchData = async () => {
      try {
        const url = view === 'week' 
          ? "http://127.0.0.1:8000/api/revenus/this-week" 
          : "http://127.0.0.1:8000/api/revenus/this-month"; // URL basée sur la vue

        const response = await axios.get(url);
        const data = response.data;

        const formattedData = data.map((item: { date: string; total_revenus: number }) => ({
          date: item.date,
          revenue: item.total_revenus,
        }));

        const totalRevenueValue = data.reduce((sum: number, item: { total_revenus: number }) => sum + item.total_revenus, 0);
        setTotalRevenue(formatNumber(totalRevenueValue));
        setChartData(formattedData);
        
        // Exemple de calcul de pourcentage
        setPercentage(view === 'week' ? -12 : -5); // Remplace avec un vrai calcul si nécessaire
      } catch (error) {
        console.error("Erreur lors du chargement des données:", error);
      }
    };

    fetchData();
  }, [view]);

  // Changer de vue toutes les 10 secondes
  useEffect(() => {
    const interval = setInterval(() => {
      setView((prevView) => (prevView === 'week' ? 'month' : 'week'));
    }, 10000); // 10 secondes

    return () => clearInterval(interval); // Nettoyage de l'intervalle lors de la destruction du composant
  }, []);

  return (
    <div>
      <ChartBox
        color="teal"
        icon="/revenueIcon.svg"
        title={`Total Revenue (${view === 'week' ? 'This Week' : 'This Month'})`} // Titre dynamique
        dataKey="revenue"
        number={totalRevenue}
        percentage={percentage}
        chartData={chartData}
      />
    </div>
  );
};

export default ChartBoxContainer;
