package principal;

import java.io.IOException;
import java.util.Iterator;

import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapreduce.Reducer;
import org.apache.hadoop.mapreduce.Reducer.Context;

public class ReduceClass extends Reducer<Text, Couleur, Text, String>{

	@Override
	protected void reduce(Text key, Iterable<Couleur> values, Context context) throws IOException, InterruptedException {
	
		double distMini = 9999;
		Integer etiqMini = 0;
		
		Iterator<Couleur> valuesIt = values.iterator();
		
		while(valuesIt.hasNext()){
			Couleur coul = valuesIt.next();
			if(coul.getDistance() < etiqMini) {
				distMini = coul.getDistance();
				etiqMini = coul.getEtiquette();
			}
		}
		
		context.write(key, etiqMini.toString());
	}	
	
}
