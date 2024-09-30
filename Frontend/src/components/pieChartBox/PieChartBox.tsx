import  { useState, useEffect } from 'react';
import axios from 'axios';
import { Cell, Pie, PieChart, ResponsiveContainer, Tooltip } from 'recharts';
import './pieChartBox.scss';

const PieChartBox = () => {
  const [data, setData] = useState([]);

  useEffect(() => {
    // Appel API pour récupérer les substances les plus exploitées
    axios.get('http://127.0.0.1:8000/api/getTopSubstance')
      .then(response => {
        // Formater les données pour le PieChart
        const formattedData = response.data.flatMap(typeSubstance => 
          typeSubstance.substances.map(substance => ({
            name: substance.nom_substance,
            value: parseInt(substance.quantite_en_chiffre),
            color: getColor(typeSubstance.nom_type_substance) // Fonction pour définir la couleur
          }))
        );
        setData(formattedData);
      })
      .catch(error => console.error('Erreur lors de la récupération des données:', error));
  }, []);

  // Fonction pour définir les couleurs des différents types de substances
  const getColor = (typeSubstance) => {
    switch (typeSubstance) {
      case 'Pierres précieuses': return '#0088FE';
      case 'Pierres fines': return '#00C49F';
      case 'Métaux Précieux': return '#FFBB28';
      case 'Pierres industrielles': return '#FF8042';
      default: return '#8884d8';
    }
  };

  return (
    <div className="pieChartBox">
      <h1>Les substances les plus exploitées</h1>
      <div className="chart">
        <ResponsiveContainer width="99%" height={300}>
          <PieChart>
            <Tooltip contentStyle={{ background: 'white', borderRadius: '5px' }} />
            <Pie
              data={data}
              innerRadius={"70%"}
              outerRadius={"90%"}
              paddingAngle={5}
              dataKey="value"
            >
              {data.map((item) => (
                <Cell key={item.name} fill={item.color} />
              ))}
            </Pie>
          </PieChart>
        </ResponsiveContainer>
      </div>
      <div className="options">
        {data.map((item) => (
          <div className="option" key={item.name}>
            <div className="title">
              <div className="dot" style={{ backgroundColor: item.color }} />
              <span>{item.name}</span>
            </div>
            <span>{item.value} {item.unite}</span>
          </div>
        ))}
      </div>
    </div>
  );
};

export default PieChartBox;
