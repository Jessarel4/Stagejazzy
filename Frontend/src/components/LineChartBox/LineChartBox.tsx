import { useState, useEffect } from 'react';
import axios from 'axios';
import { LineChart, Line, XAxis, YAxis, CartesianGrid, Tooltip, Legend, ResponsiveContainer } from 'recharts';

interface ZeData {
  name: string;
  redevance: number;
  ristourne: number;
  revenu: number;
  quantite_en_lettre: string; // Ajout du champ quantite_en_lettre
}

export const LineChartBox = () => {
  const [data, setData] = useState<ZeData[]>([]);
  const [currentYear, setCurrentYear] = useState<number>(new Date().getFullYear()); // Gérer l'année actuelle

  useEffect(() => {
    // Requête API pour obtenir les données de l'année sélectionnée
    axios.get(`http://127.0.0.1:8000/api/top-ze-annee/${currentYear}`)
      .then((response) => {
        console.log(response.data.topZe); // Vérifiez la structure des données ici
        // Formater les données pour correspondre au graphique
        const formattedData = response.data.topZe.map((item: any) => ({
          name: item.nom_ze,
          redevance: item.total_redevance,
          ristourne: item.total_ristourne,
          revenu: item.total_redevance + item.total_ristourne,
          quantite_en_lettre: item.quantite_en_lettre, // Ajout de la quantité en lettres
        }));

        setData(formattedData);
      })
      .catch((error) => {
        console.error('Erreur lors du chargement des données du top Ze:', error);
      });
  }, [currentYear]); // Mettre à jour les données lorsqu'on change d'année

  // Fonctions pour naviguer entre les années
  const goToPreviousYear = () => {
    setCurrentYear((prev) => prev - 1);
  };

  const goToNextYear = () => {
    setCurrentYear((prev) => prev + 1);
  };

  return (
    <div className='lineChartBox' style={{ width: '100%', height: 400 }}>
      <h2 style={{ marginLeft: '100px', marginBottom: '20px' }}>Top 5 des Ze</h2>
      <ResponsiveContainer width="100%" height="100%">
        <LineChart
          data={data}
          margin={{
            top: 5,
            right: 30,
            left: 20,
            bottom: 5,
          }}
        >
          <CartesianGrid strokeDasharray="3 3" />
          <XAxis dataKey="name" />
          <YAxis />
          <Tooltip 
            content={({ active, payload }) => {
              if (active && payload && payload.length) {
                const { name, redevance, ristourne, quantite_en_lettre } = payload[0].payload;
                return (
                  <div className="custom-tooltip">
                    <p>{name}</p>
                    <p>Redevance: {redevance}</p>
                    <p>Ristourne: {ristourne}</p>
                    <p>Quantité en lettres: {quantite_en_lettre}</p>
                  </div>
                );
              }
              return null;
            }} 
          />
          <Legend />
          <Line type="monotone" dataKey="redevance" stroke="#8884d8" activeDot={{ r: 8 }} />
          <Line type="monotone" dataKey="ristourne" stroke="#82ca9d" />
          <Line type="monotone" dataKey="revenu" stroke="grey" />
        </LineChart>
      </ResponsiveContainer>
      <div className="year-navigation">
        <button onClick={goToPreviousYear}>{"<<"}</button>
        <span>Année {currentYear}</span>
        <button onClick={goToNextYear}>{">>"}</button>
      </div>
    </div>
  );
};
