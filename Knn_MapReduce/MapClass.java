package principal;

import java.io.IOException;
import java.util.StringTokenizer;

import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.LongWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapreduce.Mapper;
import org.apache.hadoop.mapreduce.Mapper.Context;

public class MapClass extends Mapper<LongWritable, Text, String, Couleur>  {
	private Couleur coul;
	
	@Override
	protected void map(LongWritable key, Text value, Context context) throws IOException, InterruptedException {
		
		// Convertir value en String:
		String line = value.toString();
		
		// Séparer les mots et constuire un itérateur:
		StringTokenizer st = new StringTokenizer(line,"\n");		// Changée
		
		while(st.hasMoreTokens()) {
	   	   String ligne = st.nextToken();							// Changée
    	   if(ligne.length() > 2) {									// Changée
	    	   coul = new Couleur(ligne);							// Changée
	    	   coul.setDistance(  Math.sqrt( (coul.getR() - Main.r) ^ 2 + (coul.getV() - Main.v) ^ 2 + (coul.getB() - Main.b) ^ 2 ));
	    	   context.write("couleur", coul);						// Changée
    	   }
		}
	}
}
